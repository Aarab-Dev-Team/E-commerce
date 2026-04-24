@extends('layouts.profile')

@section('title', 'My Orders — Aura Studio')

@push('styles')
    @vite(['resources/css/profile-orders.css'])
@endpush

@section('profile-content')
    <div class="page-title">
        <h1>My Orders</h1>
        <p>Track and manage your recent purchases.</p>
    </div>

    {{-- Filters Bar (static for now, can be made dynamic later) --}}
    <div class="filters-bar">
        <div class="filter-pills">
            <a href="{{ route('profile.orders', ['status' => 'all']) }}" class="filter-pill {{ request('status', 'all') === 'all' ? 'active' : '' }}">All</a>
            <a href="{{ route('profile.orders', ['status' => 'pending']) }}" class="filter-pill {{ request('status') === 'pending' ? 'active' : '' }}">Pending</a>
            <a href="{{ route('profile.orders', ['status' => 'processing']) }}" class="filter-pill {{ request('status') === 'processing' ? 'active' : '' }}">Processing</a>
            <a href="{{ route('profile.orders', ['status' => 'delivered']) }}" class="filter-pill {{ request('status') === 'delivered' ? 'active' : '' }}">Delivered</a>
        </div>
        <select class="sort-select" onchange="window.location.href = this.value">
            <option value="{{ route('profile.orders', ['sort' => 'newest']) }}" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest first</option>
            <option value="{{ route('profile.orders', ['sort' => 'oldest']) }}" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest first</option>
            <option value="{{ route('profile.orders', ['sort' => 'highest']) }}" {{ request('sort') === 'highest' ? 'selected' : '' }}>Highest price</option>
        </select>
    </div>

    {{-- Orders Table --}}
    <div class="orders-card">
        <div class="table-header">
            <div>Order ID</div>
            <div>Date</div>
            <div>Total</div>
            <div>Status</div>
            <div>Action</div>
        </div>

        @forelse($orders as $order)
            <div class="table-row">
                <div class="col col-id">#{{ $order->order_number }}</div>
                <div class="col col-date">{{ $order->created_at->format('d M Y') }}</div>
                <div class="col col-total">${{ number_format($order->total_amount, 2) }}</div>
                <div class="col col-status">
                    <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="col col-action">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-link">View Details</a>
                </div>
            </div>
        @empty
            <div class="table-row">
                <div class="col" style="grid-column: span 5; text-align: center; padding: 40px; display: flex; justify-content: center; align-items: center;">
                    No orders found.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div class="pagination">
            {{-- Previous --}}
            @if($orders->onFirstPage())
                <span class="page-btn disabled"><i class="iconoir-nav-arrow-left"></i></span>
            @else
                <a href="{{ $orders->previousPageUrl() }}" class="page-btn"><i class="iconoir-nav-arrow-left"></i></a>
            @endif

            {{-- Pages --}}
            @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="page-btn {{ $page == $orders->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach

            {{-- Next --}}
            @if($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" class="page-btn"><i class="iconoir-nav-arrow-right"></i></a>
            @else
                <span class="page-btn disabled"><i class="iconoir-nav-arrow-right"></i></span>
            @endif
        </div>
    @endif
@endsection