@extends('layouts.admin')

@section('title', 'Orders — Aura. Admin')
@section('page-title', 'Orders')

@section('content')
<div class="page">
    <div class="section-header">
        <div>
            <h1>Order management</h1>
            <p>Process and track customer purchases.</p>
        </div>
    </div>

    {{-- Status Tabs --}}
    <div class="tabs" style="margin-bottom: 24px;">
        <a href="{{ route('admin.orders.index', ['status' => 'all']) }}" class="tab {{ request('status', 'all') === 'all' ? 'active' : '' }}">
            All ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="tab {{ request('status') === 'pending' ? 'active' : '' }}">
            Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="tab {{ request('status') === 'processing' ? 'active' : '' }}">
            Processing ({{ $counts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="tab {{ request('status') === 'shipped' ? 'active' : '' }}">
            Shipped ({{ $counts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="tab {{ request('status') === 'delivered' ? 'active' : '' }}">
            Delivered ({{ $counts['delivered'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="tab {{ request('status') === 'cancelled' ? 'active' : '' }}">
            Cancelled ({{ $counts['cancelled'] }})
        </a>
    </div>

    {{-- Search bar --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" style="display: flex; gap: 16px; margin-bottom: 24px;">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <div class="search-container" style="width: 320px; border-bottom: 1px solid var(--border-subtle);">
            <i class="iconoir-search"></i>
            <input type="text" name="search" placeholder="Search order no. or customer..." value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn btn-ghost" style="padding: 6px 16px;">Search</button>
    </form>

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