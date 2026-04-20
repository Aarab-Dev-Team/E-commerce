@extends('layouts.app')

@section('title', 'Order Confirmation — Aura Studio')

@push('styles')
    @vite(['resources/css/confirmation.css'])
@endpush

@section('content')
<div class="confirmation-page">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 40px 24px 80px;">
        
        {{-- Success Header --}}
        <div class="success-header">
            <i class="iconoir-check-circle success-icon"></i>
            <h1>Thank you for your order!</h1>
            <p>Your order <span class="order-number">#{{ $order->order_number }}</span> has been placed successfully.</p>
        </div>

        {{-- Order Information Grid --}}
        <div class="info-grid">
            <div class="info-card">
                <h2>Order Details</h2>
                <ul class="info-list">
                    <li>
                        <span class="label">Date</span>
                        <span class="value">{{ $order->created_at->format('F d, Y') }}</span>
                    </li>
                    <li>
                        <span class="label">Status</span>
                        <span class="value"><span class="status-badge">{{ ucfirst($order->status) }}</span></span>
                    </li>
                    <li>
                        <span class="label">Payment Method</span>
                        <span class="value">
                            @if($order->payment_method === 'cod')
                                Cash on Delivery
                            @elseif($order->payment_method === 'cc')
                                Credit Card
                            @else
                                PayPal
                            @endif
                        </span>
                    </li>
                </ul>
            </div>

            <div class="info-card">
                <h2>Shipping Address</h2>
                <div class="address-format">
                    {!! nl2br(e($order->shipping_address)) !!}
                </div>
            </div>
        </div>

        {{-- Items Ordered --}}
        <div class="items-section">
            <h2>Items Ordered</h2>
            
            <div class="product-list">
                @foreach($order->items as $item)
                <div class="product-item">
                    <div class="product-info">
                        <div class="product-img">
                            @if($item->product && $item->product->images && isset($item->product->images[0]))
                                <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <i class="iconoir-camera"></i>
                            @endif
                        </div>
                        <div class="product-details">
                            <p>{{ $item->product_name }}</p>
                            <span>Qty: {{ $item->quantity }}</span>
                        </div>
                    </div>
                    <div class="product-price">${{ number_format($item->total_price, 2) }}</div>
                </div>
                @endforeach
            </div>

            <div class="totals-block">
                <div class="total-line">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="total-line grand-total">
                    <span>Total</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- What's Next / Actions --}}
        <div class="whats-next">
            <p>We've received your order. You will receive a confirmation email shortly with your receipt and shipping updates.</p>
            <div class="action-buttons">
                <a href="{{ route('shop.catalog') }}" class="btn-filled">Continue Shopping</a>
                <a href="{{ route('orders.show',  $order->order_number) }}" class="btn-ghost">View Order Details</a>
            </div>
        </div>

    </div>
</div>
@endsection