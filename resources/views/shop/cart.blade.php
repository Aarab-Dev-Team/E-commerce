@extends('layouts.app')

@section('title', 'Your Cart — Aura Studio')

@push('styles')
    @vite(['resources/css/cart.css'])
@endpush

@section('content')
<div class="cart-page">
    <div class="container">
        {{-- Progress Indicator --}}
        <div class="progress-indicator" style="margin: 40px 0 20px;">
            <span class="active">Cart</span> / 
            <span>Checkout</span> / 
            <span>Payment</span>
        </div>

        <div class="cart-layout">
            {{-- Cart Items Section --}}
            <div class="cart-items-section">
                <div class="cart-header-text">
                    <h1>Your cart</h1>
                    <p>You have {{ $count }} {{ Str::plural('item', $count) }} in your cart.</p>
                </div>

                @if($items->isEmpty())
                    <div class="cart-empty" style="padding: 60px 0; text-align: center;">
                        <p>Your cart is empty.</p>
                        <a href="{{ route('shop.catalog') }}" class="btn btn-primary" style="margin-top: 20px; display: inline-block; width: auto;">Continue shopping</a>
                    </div>
                @else
                    <div class="cart-items">
                        @foreach($items as $item)
                            <div class="cart-item">
                                <div class="item-image">
                                    @if($item->product->images && isset($item->product->images[0]))
                                        <img src="{{ $item->product->images[0] }}" alt="{{ $item->product->name }}">
                                    @else
                                        <i class="iconoir-camera" style="font-size: 32px; opacity: 0.2;"></i>
                                    @endif
                                </div>
                                <div class="item-details">
                                    <h3>{{ $item->product->name }}</h3>
                                    <p class="item-meta">
                                        {{ $item->product->material ?? 'Material' }} • 
                                        {{ $item->product->origin ?? 'Origin' }}
                                    </p>
                                    <div class="item-actions">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <div class="qty-control">
                                                <button type="button" class="qty-btn" onclick="decrementQty(this)">-</button>
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="qty-number" style="width: 50px; text-align: center; border: none; background: transparent;" onchange="this.form.submit()">
                                                <button type="button" class="qty-btn" onclick="incrementQty(this)">+</button>
                                            </div>
                                        </form>
                                        <div class="item-price">${{ number_format($item->price_at_time * $item->quantity, 2) }}</div>
                                    </div>
                                </div>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn" aria-label="Remove item">
                                        <i class="iconoir-cancel"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Summary Section --}}
            @if(!$items->isEmpty())
            <div class="summary-section">
                <div class="summary-card">
                    <h2>Summary</h2>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Calculated at checkout</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    {{-- {{ route('checkout.index') }} --}}
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="display: block; margin-bottom: 16px;">Proceed to checkout</a>
                    <a href="{{ route('shop.catalog') }}" class="btn btn-ghost" style="display: block;">Continue shopping</a>

                    {{-- Promo Code --}}
                    <div class="promo-code">
                        <input type="text" class="promo-input" placeholder="Enter coupon code">
                        <button class="btn-apply">Apply</button>
                    </div>

                    {{-- Trust Signals --}}
                    <div class="trust-signals">
                        <div class="trust-item">
                            <i class="iconoir-lock"></i>
                            <span>Secure encrypted checkout</span>
                        </div>
                        <div class="trust-item">
                            <i class="iconoir-delivery-truck"></i>
                            <span>Free shipping on orders over $150</span>
                        </div>
                        <div class="trust-item">
                            <i class="iconoir-refresh-double"></i>
                            <span>30-day easy return policy</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Recommended Products --}}
        @if($recommended->count() > 0)
        <section class="recommended">
            <h2>You may also like</h2>
            <div class="recommended-grid">
                @foreach($recommended as $product)
                    <div class="product-card">
                        <a href="{{ route('shop.product', $product->slug) }}">
                            <div class="product-img-box">
                                @if($product->images && isset($product->images[0]))
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}">
                                @else
                                    <i class="iconoir-camera" style="font-size: 32px; opacity: 0.2;"></i>
                                @endif
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <p class="item-price">${{ number_format($product->price, 2) }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function incrementQty(btn) {
        const input = btn.parentElement.querySelector('input');
        const val = parseInt(input.value);
        if (val < 99) {
            input.value = val + 1;
            input.form.submit();
        }
    }

    function decrementQty(btn) {
        const input = btn.parentElement.querySelector('input');
        const val = parseInt(input.value);
        if (val > 1) {
            input.value = val - 1;
            input.form.submit();
        }
    }
</script>
@endpush