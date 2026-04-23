<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order   ; 
use App\Models\Product ; 

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalRevenue = Order::whereNotIn('status', ['cancelled', 'refunded'])->sum('total_amount');

        // Recent orders (latest 5)
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'activeProducts',
            'totalRevenue',
            'recentOrders'
        ));
    }
}
