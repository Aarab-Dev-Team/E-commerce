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
                    <div class="cart-empty" >
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
                                        <div class="qty-control"
                                             data-item-id="{{ $item->id }}"
                                             data-update-url="{{ route('cart.update', $item->id) }}"
                                             data-price="{{ $item->price_at_time }}">
                                            <button type="button" class="qty-btn" onclick="decrementQty(this)">-</button>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99"
                                                   class="qty-number"
                                                   style="width: 50px; text-align: center; border: none; background: transparent;"
                                                   onchange="updateQty(this)">
                                            <button type="button" class="qty-btn" onclick="incrementQty(this)">+</button>
                                        </div>
                                        <div class="item-price" data-item-price="{{ $item->id }}">${{ number_format($item->price_at_time * $item->quantity, 2) }}</div>
                                    </div>
                                </div>
                                <button type="button" class="remove-btn" aria-label="Remove item"
                                        data-remove-url="{{ route('cart.remove', $item->id) }}"
                                        onclick="removeItem(this)">
                                    <i class="iconoir-xmark-square" style="font-size: 28px;"></i>
                                </button>
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
                        <span id="summary-subtotal">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Calculated at checkout</span>
                    </div>
                    
                    @php
                        $appliedCouponCode = session('applied_coupon');
                        $appliedCoupon     = $appliedCouponCode ? \App\Models\Coupon::where('code', $appliedCouponCode)->first() : null;
                        $discountAmount    = 0;
                        if ($appliedCoupon && $appliedCoupon->isValid((float) $subtotal)) {
                            $discountAmount = $appliedCoupon->calculateDiscount((float) $subtotal);
                        } elseif ($appliedCouponCode) {
                            session()->forget('applied_coupon');
                            $appliedCoupon = null;
                        }
                        $orderTotal = max(0, $subtotal - $discountAmount);
                    @endphp

                    <div class="summary-row total">
                        <span>Total</span>
                        <div style="display: flex; flex-direction: column; align-items: flex-end;">
                            @if($discountAmount > 0)
                                <span id="summary-original-total" style="color: #ff0000; text-decoration: line-through; font-size: 0.85em; margin-bottom: 2px;">${{ number_format($subtotal, 2) }}</span>
                            @endif
                            <span id="summary-total">${{ number_format($orderTotal, 2) }}</span>
                        </div>
                    </div>
                    
                    {{-- {{ route('checkout.index') }} --}}
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="display: block; margin-bottom: 16px;">Proceed to checkout</a>
                    <a href="{{ route('shop.catalog') }}" class="btn btn-ghost" style="display: block;">Continue shopping</a>

                    {{-- Coupon Code --}}

                    <div class="coupon-section">
                        @if($appliedCoupon)
                            <div class="coupon-applied">
                                <div class="coupon-applied-info">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
                                    <span><strong>{{ $appliedCoupon->code }}</strong>
                                        — {{ $appliedCoupon->type === 'percentage' ? $appliedCoupon->value . '% off' : '$' . number_format($appliedCoupon->value, 2) . ' off' }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('cart.coupon.remove') }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="coupon-remove" title="Remove coupon">×</button>
                                </form>
                            </div>
                        @else
                            <form method="POST" action="{{ route('cart.coupon.apply') }}" class="coupon-form">
                                @csrf
                                <input type="text" name="coupon_code"
                                       class="coupon-input {{ $errors->has('coupon_code') ? 'coupon-input-error' : '' }}"
                                       placeholder="Enter coupon code"
                                       value="{{ old('coupon_code') }}"
                                       autocomplete="off">
                                <button type="submit" class="coupon-btn">Apply</button>
                            </form>
                            @error('coupon_code')
                                <p class="coupon-error">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>

                    {{-- Updated totals with discount --}}
                    @if($discountAmount > 0)
                    <div class="summary-row discount-row">
                        <span>Discount</span>
                        <span class="discount-value">−${{ number_format($discountAmount, 2) }}</span>
                    </div>
                    @endif

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
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

    function fmt(num) {
        return '$' + Number(num).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function updateQty(input) {
        const ctrl   = input.closest('.qty-control');
        const itemId = ctrl.dataset.itemId;
        const price  = parseFloat(ctrl.dataset.price);
        const qty    = Math.max(1, Math.min(99, parseInt(input.value) || 1));
        input.value  = qty;
        input.disabled = true;

        fetch(ctrl.dataset.updateUrl, {
            method : 'POST',
            headers: {
                'Content-Type'    : 'application/json',
                'Accept'          : 'application/json',
                'X-CSRF-TOKEN'    : CSRF,
                'X-HTTP-Method-Override': 'PATCH',
            },
            body: JSON.stringify({ quantity: qty, _method: 'PATCH' }),
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) return;

            // update this row's line total
            const priceEl = document.querySelector(`[data-item-price="${itemId}"]`);
            if (priceEl) priceEl.textContent = fmt(price * qty);

            // update summary
            const sub  = document.getElementById('summary-subtotal');
            const tot  = document.getElementById('summary-total');
            const orig = document.getElementById('summary-original-total');

            if (sub)  sub.textContent = fmt(data.subtotal);
            if (tot)  tot.textContent = fmt(data.subtotal);
            if (orig) orig.style.display = 'none';

            // update nav badge if present
            document.querySelectorAll('[data-cart-count]').forEach(el => {
                el.textContent = data.cart_count;
                el.dataset.cartCount = data.cart_count;
            });
        })
        .catch(() => { /* silently fail – user can still reload */ })
        .finally(() => { input.disabled = false; });
    }

    function incrementQty(btn) {
        const input = btn.parentElement.querySelector('input');
        const val   = parseInt(input.value);
        if (val < 99) { input.value = val + 1; updateQty(input); }
    }

    function decrementQty(btn) {
        const input = btn.parentElement.querySelector('input');
        const val   = parseInt(input.value);
        if (val > 1) { input.value = val - 1; updateQty(input); }
    }

    function removeItem(btn) {
        btn.disabled = true;
        const url = btn.dataset.removeUrl;

        fetch(url, {
            method : 'POST',
            headers: {
                'Content-Type' : 'application/json',
                'Accept'       : 'application/json',
                'X-CSRF-TOKEN' : CSRF,
                'X-HTTP-Method-Override': 'DELETE',
            },
            body: JSON.stringify({ _method: 'DELETE' }),
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) { btn.disabled = false; return; }

            // remove the cart-item row with a fade-out
            const row = btn.closest('.cart-item');
            if (row) {
                row.style.transition = 'opacity 0.3s';
                row.style.opacity    = '0';
                setTimeout(() => row.remove(), 300);
            }

            // update summary
            const sub  = document.getElementById('summary-subtotal');
            const tot  = document.getElementById('summary-total');
            const orig = document.getElementById('summary-original-total');

            if (sub)  sub.textContent = fmt(data.subtotal);
            if (tot)  tot.textContent = fmt(data.subtotal);
            if (orig) orig.style.display = 'none';

            // update nav badge
            document.querySelectorAll('[data-cart-count]').forEach(el => {
                el.textContent = data.cart_count;
                el.dataset.cartCount = data.cart_count;
            });

            // if cart is now empty, reload to show the empty state
            if (data.cart_count === 0) {
                setTimeout(() => location.reload(), 350);
            }
        })
        .catch(() => { btn.disabled = false; });
    }
</script>
@endpush