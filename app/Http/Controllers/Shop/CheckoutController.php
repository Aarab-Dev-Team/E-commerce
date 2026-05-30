<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cartItems = $this->cartService->items();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cartService->subtotal();
        $addresses = collect();

        if (auth()->check()) {
            $addresses = auth()->user()->addresses;
        }

        // Resolve applied coupon from session
        $appliedCoupon  = null;
        $discountAmount = 0;
        if (session('applied_coupon')) {
            $coupon = Coupon::where('code', session('applied_coupon'))->first();
            if ($coupon && $coupon->isValid((float) $subtotal)) {
                $appliedCoupon  = $coupon;
                $discountAmount = $coupon->calculateDiscount((float) $subtotal);
            } else {
                session()->forget('applied_coupon');
            }
        }
        $total = max(0, $subtotal - $discountAmount);

        return view('shop.checkout', compact('cartItems', 'subtotal', 'addresses', 'appliedCoupon', 'discountAmount', 'total'));
    }

    /**
     * Process the checkout and create the order.
     */
    public function store(Request $request)
    {
        $cartItems = $this->cartService->items();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:2',
            'payment_method' => 'required|in:cod,cc,paypal',
        ]);

        // Build shipping address string (no HTML tags — plain text only)
        $shippingAddress = implode("\n", array_filter([
            'Name: ' . $validated['name'],
            'Address: ' . $validated['address_line_1'],
            $validated['address_line_2'] ? 'Address 2: ' . $validated['address_line_2'] : null,
            'City/State/Zip: ' . $validated['city'] . ', ' . $validated['state'] . ' ' . $validated['postal_code'],
            'Country: ' . $validated['country'],
            'Phone: ' . $validated['phone'],
            'Email: ' . $validated['email'],
        ]));

        $subtotal = $this->cartService->subtotal();

        return DB::transaction(function () use ($cartItems, $validated, $subtotal, $shippingAddress) {
            // Validate stock for every item
            $productIds = $cartItems->pluck('product_id')->toArray();
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($cartItems as $item) {
                $product = $products->get($item->product_id);
                if (!$product) {
                    abort(422, 'Product not found: ' . $item->product->name);
                }
                if ($product->stock_quantity < $item->quantity) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Insufficient stock for "' . $product->name . '". Only ' . $product->stock_quantity . ' left.');
                }
            }

            // Apply coupon from session
            $couponCode     = null;
            $discountAmount = 0;
            if (session('applied_coupon')) {
                $coupon = Coupon::where('code', session('applied_coupon'))->first();
                if ($coupon && $coupon->isValid((float) $subtotal)) {
                    $discountAmount = $coupon->calculateDiscount((float) $subtotal);
                    $couponCode     = $coupon->code;
                    $coupon->increment('uses');
                }
                session()->forget('applied_coupon');
            }

            $total = max(0, $subtotal - $discountAmount);

            // Determine payment status
            $paymentStatus = ($validated['payment_method'] === 'cod') ? 'pending' : 'paid';

            // Create order with UUID-based order number
            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
                'total_amount'     => $total,
                'status'           => 'pending',
                'payment_status'   => $paymentStatus,
                'payment_method'   => $validated['payment_method'],
                'shipping_address' => $shippingAddress,
                'coupon_code'      => $couponCode,
                'discount_amount'  => $discountAmount,
            ]);

            // Move cart items to order items + decrement stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->price_at_time,
                    'total_price'  => $item->price_at_time * $item->quantity,
                ]);

                $products[$item->product_id]->decrement('stock_quantity', $item->quantity);
            }

            // Clear the cart
            $this->cartService->clear();

            return redirect()->route('checkout.confirmation', $order)->with('success', 'Order placed successfully!');
        });
    }

    /**
     * Show order confirmation page.
     */
    public function confirmation(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('shop.confirmation', compact('order'));
    }
}
