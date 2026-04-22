<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $search . '%'));
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $counts = [
            'all'        => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    /**
     * Display the specified order (JSON for modal or full page).
     */
    public function show(Order $order)
    {
        $order->load('items.product', 'user');

        if (request()->expectsJson()) {
            return response()->json($order);
        }

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Order status updated.']);
        }

        return redirect()->route('admin.orders.index')->with('alert', [
            'type'    => 'success',
            'message' => 'Order status updated.',
        ]);
    }

    /**
     * Delete an order — admin only.
     */
    public function destroy(Order $order)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can delete orders.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('alert', [
            'type'    => 'success',
            'message' => 'Order #' . $order->order_number . ' has been deleted.',
        ]);
    }
}
