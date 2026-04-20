<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order ; 
use App\Models\OrderItem ; 
use App\Models\Product ; 

class OrderController extends Controller
{
    

        /**
     * show orders
     */
    public function index(Request $request)
    {
        $query = auth()->user()->orders();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sort
        match ($request->input('sort', 'newest')) {
            'oldest' => $query->oldest(),
            'highest' => $query->orderBy('total_amount', 'desc'),
            default => $query->latest(),
        };

        $orders = $query->paginate(10)->withQueryString();

        return view('profile.orders.index', compact('orders'));
    }

    /**
     * order detail
     */
    public function show( $order)
    {    
        $order = Order::findOrFail($order) ; 
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        $progressWidth = $this->calculateProgressWidth($order->status);

        return view('orders.show', compact('order', 'progressWidth'));
    }

    /**
     * calculate progress
     */
    private function calculateProgressWidth(string $status): int
    {
        return match ($status) {
            'pending' => 25,
            'processing' => 50,
            'shipped' => 75,
            'delivered' => 100,
            default => 0,
        };
    }


}
