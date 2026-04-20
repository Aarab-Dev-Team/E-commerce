@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' — Aura Studio')

@push('styles')
    @vite(['resources/css/order-details.css'])
@endpush

@section('content')
<div class="order-details-page container">
    <div class="page-header">
        <a href="{{ route('orders.index') }}" class="back-link">
            <i class="iconoir-arrow-left"></i> Back to all orders
        </a>
        <h1>
            Order #{{ $order->order_number }}
            <span class="badge badge-{{ $order->status === 'delivered' ? 'delivered' : ($order->status === 'shipped' ? 'shipped' : 'pending') }}">
                {{ ucfirst($order->status) }}
            </span>
        </h1>
        <p>Placed on {{ $order->created_at->format('d F Y') }} at {{ $order->created_at->format('H:i') }}</p>
    </div>

    <div class="order-layout">
        <div class="main-column">
            {{-- Tracking Timeline --}}
            <div class="card">
                <div class="card-header">
                    <h2>Tracking status</h2>
                    <p>Estimated delivery: {{ $order->created_at->addDays(5)->format('d F Y') }}</p>
                </div>

                <div class="timeline">
                    <div class="timeline-progress" style="width: {{ $progressWidth }}%;"></div>

                    @php
                        $steps = [
                            'pending' => ['Order placed', 'iconoir-check'],
                            'processing' => ['Processing', 'iconoir-settings'],
                            'shipped' => ['Shipped', 'iconoir-package'],
                            'delivered' => ['Delivered', 'iconoir-home'],
                        ];
                        $statuses = array_keys($steps);
                        $currentIndex = array_search($order->status, $statuses);
                    @endphp

                    @foreach($steps as $status => $label)
                        @php
                            $stepIndex = array_search($status, $statuses);
                            $isCompleted = $stepIndex < $currentIndex;
                            $isCurrent = $status === $order->status;
                        @endphp
                        <div class="timeline-step">
                            <div class="step-dot {{ $isCompleted ? 'active' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                @if($isCompleted)
                                    <i class="iconoir-check"></i>
                                @endif
                            </div>
                            <div class="step-text {{ $isCompleted || $isCurrent ? 'active-text' : '' }}">
                                {{ $label[0] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Items Ordered --}}
            <div class="card">
                <div class="card-header">
                    <h2>Items in this order</h2>
                </div>

                <div class="product-list">
                    @foreach($order->items as $item)
                        <div class="product-row">
                            <div class="product-image">
                                @if($item->product && $item->product->images && isset($item->product->images[0]))
                                    <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}">
                                @else
                                    <i class="iconoir-camera" style="font-size: 24px; opacity: 0.3;"></i>
                                @endif
                            </div>
                            <div class="product-details">
                                <h3>{{ $item->product_name }}</h3>
                                <p class="meta-text">
                                    {{ $item->product->material ?? 'Material' }} • {{ $item->product->origin ?? 'Origin' }}
                                </p>
                                <p class="meta-text" style="margin-top: 4px;">Price: ${{ number_format($item->unit_price, 2) }}</p>
                            </div>
                            <div class="product-price-info">
                                <div class="qty">Qty: {{ $item->quantity }}</div>
                                <div class="subtotal">${{ number_format($item->total_price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="side-column">
            {{-- Order Summary --}}
            <div class="card">
                <div class="card-header">
                    <h2>Order summary</h2>
                </div>

                <div class="summary-row">
                    <span>Subtotal ({{ $order->items->sum('quantity') }} items)</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            {{-- Details --}}
            <div class="card">
                <div class="card-header">
                    <h2>Details</h2>
                </div>

                <div class="info-block">
                    <h3>Shipping Address</h3>
                    {!! nl2br(e($order->shipping_address)) !!}
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <h3>Payment Method</h3>
                    <p>
                        @if($order->payment_method === 'cod')
                            Cash on Delivery
                        @elseif($order->payment_method === 'cc')
                            Credit Card
                        @else
                            PayPal
                        @endif
                    </p>
                    <p style="margin-top: 8px;">
                        <span class="badge badge-paid" style="font-size: 0.75rem;">{{ ucfirst($order->payment_status) }}</span>
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div>
                <button class="btn btn-primary"><i class="iconoir-delivery-truck"></i> Track shipment</button>
                <button class="btn btn-ghost"><i class="iconoir-download"></i> Download invoice</button>
                <button class="btn-danger-link">Report an issue</button>
            </div>

            {{-- Support Box --}}
            <div class="support-box">
                <h3>Need help with this order?</h3>
                <p style="margin-bottom: 16px; font-size: 0.875rem;">Our team is here for you.</p>
                <a href="#" style="color: var(--text-main); font-weight: 500; font-size: 0.875rem;">Contact Support →</a>
            </div>
        </div>
    </div>
</div>
@endsection