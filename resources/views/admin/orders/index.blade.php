@extends('layouts.admin')

@section('title', 'Orders — Aura. Admin')
@section('page-title', 'Orders')


@section('content')
<div class="page">
    {{-- Breadcrumbs --}}
    <nav class="breadcrumbs" style="margin-bottom: 24px; font-size: 13px; color: var(--text-secondary);">
        <a href="{{ route('admin.dashboard') }}" style="color: var(--text-secondary);">Admin</a>
        <span style="margin: 0 8px;">/</span>
        <span style="color: var(--text-primary);">Orders</span>
    </nav>

    {{-- Editorial Hero --}}
    <header class="editorial-hero" style="position: relative; margin-bottom: 80px;">
        <h1 style="max-width: 600px; margin-bottom: 16px;">Order management</h1>
        <p style="font-size: 18px; max-width: 500px;">Process and track customer purchases with ease.</p>
        
        {{-- Hand-drawn Illustration --}}
        <svg class="hero-decor" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.8;">
            <path d="M50 40 C 55 38, 65 37, 70 40 C 75 43, 130 43, 135 40 C 140 37, 145 38, 150 40 L 155 160 C 150 163, 140 165, 135 162 C 130 159, 75 159, 70 162 C 65 165, 55 163, 50 160 Z" 
                  stroke="var(--text-primary)" stroke-width="1.2" fill="none" />
            <path d="M70 70 L 130 70 M 70 95 L 130 95 M 70 120 L 105 120" 
                  stroke="var(--accent-clay)" stroke-width="1" fill="none" stroke-linecap="round" />
        </svg>
    </header>

    {{-- Status Tabs --}}
    <div class="tabs" style="margin-bottom: 48px;">
        <a href="{{ route('admin.orders.index', ['status' => 'all']) }}" class="tab {{ request('status', 'all') === 'all' ? 'active' : '' }}">
            All orders ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="tab {{ request('status') === 'pending' ? 'active' : '' }}">
            Pending  ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="tab {{ request('status') === 'processing' ? 'active' : '' }}">
            Processing   ({{ $counts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="tab {{ request('status') === 'shipped' ? 'active' : '' }}">
            Shipped ({{ $counts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="tab {{ request('status') === 'delivered' ? 'active' : '' }}">
            Delivered ({{ $counts['delivered'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="tab {{ request('status') === 'cancelled' ? 'active' : '' }}">
            Cancelled  ({{ $counts['cancelled'] }})
        </a>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="filter-controls" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;">
        <form method="GET" action="{{ route('admin.orders.index') }}" style="display: flex; gap: 24px; align-items: flex-end;">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="form-group" style="margin-bottom: 0;">
                <label>Search orders</label>
                <div class="search-boxed">
                    <i class="iconoir-search"></i>
                    <input type="text" name="search" placeholder="Order no. or customer..." value="{{ request('search') }}">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.orders.index', ['status' => request('status')]) }}" class="btn btn-ghost">Clear</a>
            @endif
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Order no.</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="font-weight: 500;">#{{ $order->order_number }}</td>
                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <span class="badge badge-{{ $order->payment_status === 'paid' ? 'paid' : 'pending' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="display: flex; align-items: center; gap: 8px;">
                        <button class="btn btn-ghost" style="padding: 5px 14px; font-size: 12px;" onclick="openOrderModal({{ $order->id }})">
                            View
                        </button>
                        {{-- Admin-only delete --}}
                        @if(auth()->user()->role === 'admin')
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Permanently delete order #{{ $order->order_number }}? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon reject" title="Delete order">
                                    <i class="iconoir-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination">
        {{ $orders->links('pagination.admin') }}
    </div>
</div>

{{-- Order Details Modal --}}
@include('admin.orders.partials.modal')
@endsection

@push('scripts')
<script>
    async function openOrderModal(orderId) {
        try {
            const response = await fetch(`/admin/orders/${orderId}`, {
                headers: { 'Accept': 'application/json' }
            });
            const order = await response.json();
            populateOrderModal(order);
            openModal('orderModal');
        } catch (error) {
            console.error('Error fetching order:', error);
        }
    }

    function populateOrderModal(order) {
        document.getElementById('modal-order-number').innerText = `#${order.order_number}`;

        const statusBadge = document.getElementById('modal-status-badge');
        statusBadge.className = `badge badge-${order.status}`;
        statusBadge.innerText = order.status.charAt(0).toUpperCase() + order.status.slice(1);

        document.getElementById('modal-order-date').innerText =
            `Placed on ${new Date(order.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}`;

        const customer = order.user || { name: 'Guest', email: 'N/A', phone: 'N/A' };
        document.getElementById('modal-customer-name').innerText  = customer.name;
        document.getElementById('modal-customer-email').innerText = customer.email;
        document.getElementById('modal-customer-phone').innerText = customer.phone || '—';

        document.getElementById('modal-shipping-address').innerHTML =
            order.shipping_address ? order.shipping_address.replace(/\n/g, '<br>') : '—';

        const itemsBody = document.getElementById('modal-items-body');
        itemsBody.innerHTML = '';
        let totalItems = 0;
        (order.items || []).forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="padding: 12px 16px;">${item.product_name}</td>
                <td style="padding: 12px 16px;">${item.quantity}</td>
                <td style="padding: 12px 16px;">$${parseFloat(item.total_price).toFixed(2)}</td>
            `;
            itemsBody.appendChild(row);
            totalItems += item.quantity;
        });

        document.getElementById('modal-total-items').innerText = `(${totalItems} items)`;
        document.getElementById('modal-subtotal').innerText = `$${parseFloat(order.total_amount).toFixed(2)}`;
        document.getElementById('modal-total').innerText    = `$${parseFloat(order.total_amount).toFixed(2)}`;

        let paymentMethod = 'Cash on delivery';
        if (order.payment_method === 'cc')     paymentMethod = 'Credit card';
        if (order.payment_method === 'paypal') paymentMethod = 'PayPal';
        document.getElementById('modal-payment-method').innerText = paymentMethod;

        const form = document.getElementById('status-update-form');
        form.action = `/admin/orders/${order.id}`;
        document.getElementById('status-select').value = order.status;

        // Set delete form action (admin only)
        const deleteForm = document.getElementById('modal-delete-form');
        if (deleteForm) deleteForm.action = `/admin/orders/${order.id}`;
    }

    document.getElementById('status-update-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                closeModal('orderModal');
                window.location.reload();
            }
        } catch (error) {
            console.error('Error updating order:', error);
        }
    });
</script>
@endpush