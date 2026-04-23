@extends('layouts.admin')

@section('title', 'Dashboard — Aura. Admin')
@section('page-title', 'Overview')

@section('content')
<div class="page">
    <div class="section-header">
        <div>
            @if(auth()->user()->role === 'admin')
                <h1>Admin dashboard</h1>
            @else
                <h1>Employee workspace</h1>
            @endif
            <p>A summary of recent activity and store metrics.</p>
        </div>
        <div style="display: flex; gap: 12px; z-index: 1;">
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Add new product</a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">View orders</a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid-4">
        <div class="card">
            <div class="stat-label">Total orders</div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <svg class="card-svg-bg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M20,30 L80,30 L80,80 L20,80 Z M20,45 L80,45 M40,30 L40,45" fill="none" stroke="var(--text-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="card">
            <div class="stat-label">Orders pending</div>
            <div class="stat-value">{{ $pendingOrders }}</div>
            <svg class="card-svg-bg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M30,20 L70,20 M30,80 L70,80 M35,20 C35,40 45,45 50,50 C55,45 65,40 65,20 M35,80 C35,60 45,55 50,50 C55,55 65,60 65,80" fill="none" stroke="var(--text-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="card">
            <div class="stat-label">Orders processing</div>
            <div class="stat-value">{{ $processingOrders }}</div>
            <svg class="card-svg-bg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="20" fill="none" stroke="var(--text-primary)" stroke-width="1.5" stroke-dasharray="4 4" stroke-linecap="round"/>
                <path d="M50,15 L50,25 M50,75 L50,85 M15,50 L25,50 M75,50 L85,50" fill="none" stroke="var(--text-primary)" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="card">
            <div class="stat-label">Active products</div>
            <div class="stat-value">{{ $activeProducts }}</div>
            <svg class="card-svg-bg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M50,80 C20,80 20,40 50,20 C80,40 80,80 50,80 Z M50,20 L50,80" fill="none" stroke="var(--text-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        {{-- Admin-only: pending approvals card --}}
        @if(auth()->user()->role === 'admin')
        <div class="card" style="border-left: 3px solid var(--accent-clay);">
            <div class="stat-label">Pending approvals</div>
            {{-- <div class="stat-value">{{ $pendingApprovals }}</div> --}}
            {{-- @if($pendingApprovals > 0)
                <a href="{{ route('admin.approvals.index') }}" style="font-size: 12px; color: var(--accent-clay); text-decoration: none; display: inline-block; margin-top: 8px;">
                    Review now →
                </a>
            @endif --}}
            <svg class="card-svg-bg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M50,20 L50,50 M50,65 L50,70" fill="none" stroke="var(--text-primary)" stroke-width="2" stroke-linecap="round"/>
                <circle cx="50" cy="50" r="35" fill="none" stroke="var(--text-primary)" stroke-width="1.5"/>
            </svg>
        </div>
        @endif
        
        {{-- Total Revenue Card --}}
        @if(auth()->user()->role === 'admin')
        <div class="card" style="border-left: 3px solid var(--accent-forest);">
            <div class="stat-label">Total revenue</div>
            <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
            <svg class="card-svg-bg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M20,60 Q40,80 60,40 T80,30" fill="none" stroke="var(--text-primary)" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M70,30 L80,30 L80,40" fill="none" stroke="var(--text-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        @endif
    </div>

    <h3 style="margin-top: 48px; margin-bottom: 16px;">Recent orders</h3>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Order no.</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td style="font-weight: 500;">#{{ $order->order_number }}</td>
                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <span class="badge badge-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.index') }}" class="table-link">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="table-link" style="font-size: 13px; display: inline-block; margin-top: 16px;">View all orders →</a>
</div>
@endsection