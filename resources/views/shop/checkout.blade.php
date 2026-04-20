@extends('layouts.app')

@section('title', 'Checkout — Aura Studio')

@push('styles')
    @vite(['resources/css/checkout.css'])
@endpush

@section('content')
<div class="checkout-page container">
    {{-- Breadcrumb & Progress --}}
    <div class="checkout-header-nav">
        <div class="breadcrumb">
            <a href="{{ url('/') }}">Home</a> / 
            <a href="{{ route('cart.index') }}">Cart</a> / 
            <span>Checkout</span>
        </div>
        <div class="progress">
            <span>Cart</span> &rarr; 
            <span class="active">Checkout</span> &rarr; 
            <span>Confirmation</span>
        </div>
    </div>

    <form method="POST" action="{{ route('checkout.store') }}" class="checkout-layout">
        @csrf
        
        {{-- Left Column: Forms --}}
        <div class="form-section">
            {{-- Shipping Address --}}
            <div class="section-block">
                <h2>Shipping Address</h2>
                
                @if($addresses->count() > 0)
                <div class="saved-address">
                    <select name="saved_address_id" id="saved_address" onchange="fillAddressFromSaved(this)">
                        <option value="">Use a saved address (optional)</option>
                        @foreach($addresses as $addr)
                            <option value="{{ $addr->id }}" 
                                data-name="{{ auth()->user()->name }}"
                                data-email="{{ auth()->user()->email }}"
                                data-phone="{{ auth()->user()->phone }}"
                                data-line1="{{ $addr->address_line_1 }}"
                                data-line2="{{ $addr->address_line_2 }}"
                                data-city="{{ $addr->city }}"
                                data-state="{{ $addr->state }}"
                                data-zip="{{ $addr->postal_code }}"
                                data-country="{{ $addr->country }}"
                            >{{ $addr->address_line_1 }}, {{ $addr->city }}</option>
                        @endforeach
                        <option value="new">+ Enter a new address</option>
                    </select>
                </div>
                @endif

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Address Line 1</label>
                        <input type="text" name="address_line_1" value="{{ old('address_line_1') }}" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Address Line 2 (Optional)</label>
                        <input type="text" name="address_line_2" value="{{ old('address_line_2') }}">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" value="{{ old('city') }}" required>
                    </div>
                    <div class="form-group">
                        <label>State/Province</label>
                        <input type="text" name="state" value="{{ old('state') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <select name="country" required>
                            <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                            <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                            <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                            <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="section-block">
                <h2>Payment Method</h2>
                
                <div class="payment-options">
                    <div class="payment-option">
                        <label>
                            <input type="radio" name="payment_method" value="cod" checked onchange="toggleCCFields()">
                            Cash on Delivery
                        </label>
                    </div>

                    <div class="payment-option">
                        <label>
                            <input type="radio" name="payment_method" value="cc" id="pay-cc" onchange="toggleCCFields()">
                            Credit Card (Test)
                        </label>
                        <div class="cc-fields" id="cc-form-fields">
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label>Card Number</label>
                                    <input type="text" name="cc_number" placeholder="4242 4242 4242 4242">
                                </div>
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="text" name="cc_expiry" placeholder="MM/YY">
                                </div>
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" name="cc_cvv" placeholder="123">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-option">
                        <label>
                            <input type="radio" name="payment_method" value="paypal" onchange="toggleCCFields()">
                            PayPal (Test)
                        </label>
                    </div>
                </div>
            </div>

            <div class="checkout-actions">
                <a href="{{ route('cart.index') }}" class="return-link">Return to Cart</a>
                <button type="submit" class="btn-place-order">Place Order</button>
            </div>
        </div>

        {{-- Right Column: Order Summary --}}
        <aside class="order-summary">
            <h3>Order Summary</h3>
            
            <div class="product-list">
                @foreach($cartItems as $item)
                <div class="product-item">
                    <div class="product-info">
                        <div class="product-img">
                            @if($item->product->images && isset($item->product->images[0]))
                                <img src="{{ $item->product->images[0] }}" alt="{{ $item->product->name }}">
                            @else
                                <i class="iconoir-camera" style="font-size: 20px; opacity: 0.3;"></i>
                            @endif
                        </div>
                        <div class="product-details">
                            <p>{{ $item->product->name }}</p>
                            <span>Qty: {{ $item->quantity }}</span>
                        </div>
                    </div>
                    <div class="product-price">${{ number_format($item->price_at_time * $item->quantity, 2) }}</div>
                </div>
                @endforeach
            </div>

            <div class="totals">
                <div class="total-line">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="total-line grand-total">
                    <span>Total</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
            </div>
        </aside>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function toggleCCFields() {
        const ccRadio = document.getElementById('pay-cc');
        const ccFields = document.getElementById('cc-form-fields');
        if (ccRadio && ccRadio.checked) {
            ccFields.style.display = 'block';
        } else {
            ccFields.style.display = 'none';
        }
    }

    function fillAddressFromSaved(select) {
        const selected = select.options[select.selectedIndex];
        if (selected.value === 'new' || selected.value === '') {
            // Clear fields or keep as is
            return;
        }
        document.querySelector('input[name="name"]').value = selected.dataset.name || '';
        document.querySelector('input[name="email"]').value = selected.dataset.email || '';
        document.querySelector('input[name="phone"]').value = selected.dataset.phone || '';
        document.querySelector('input[name="address_line_1"]').value = selected.dataset.line1 || '';
        document.querySelector('input[name="address_line_2"]').value = selected.dataset.line2 || '';
        document.querySelector('input[name="city"]').value = selected.dataset.city || '';
        document.querySelector('input[name="state"]').value = selected.dataset.state || '';
        document.querySelector('input[name="postal_code"]').value = selected.dataset.zip || '';
        document.querySelector('select[name="country"]').value = selected.dataset.country || 'US';
    }

    // Initialize CC fields on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleCCFields();
    });
</script>
@endpush