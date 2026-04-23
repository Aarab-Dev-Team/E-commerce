@extends('layouts.app')

@section('title', $product->name . ' — Aura Studio')

@push('styles')
@vite(['resources/css/product.css'])
<style>
    
    .rating i.active { color: var(--text-main); }
    .rating i.inactive { color: var(--border-color); }
</style>
@endpush

@section('content')

<div class="product-page">
    {{-- Product Hero Section --}}
    <section class="product-hero container">
        <div class="grid-12">
            {{-- Gallery --}}
            <div class="product-gallery">
                <div class="image-placeholder main-image">
                    @if($product->images && isset($product->images[0]))
                        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <i class="iconoir-camera" style="font-size: 48px; opacity: 0.2;"></i>
                    @endif
                </div>
                <div class="thumbnail-list">
                    @if($product->images && count($product->images) > 1)
                        @foreach($product->images as $index => $image)
                            @if($index > 0 && $index < 4)
                                <div class="image-placeholder thumbnail" onclick="changeMainImage('{{ $image }}')">
                                    <img src="{{ $image }}" alt="Thumbnail {{ $index }}" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                            @endif
                        @endforeach
                    @else
                        {{-- Placeholder thumbnails --}}
                        <div class="image-placeholder thumbnail"></div>
                        <div class="image-placeholder thumbnail"></div>
                        <div class="image-placeholder thumbnail"></div>
                    @endif
                </div>
            </div>

            {{-- Product Info --}}
            <div class="product-info">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}">Home</a> <span>/</span>
                    <a href="{{ route('shop.catalog') }}">Objects</a> <span>/</span>
                    {{ $product->name }}
                </div>

                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>

                {{-- Rating --}}
                <div class="rating">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="iconoir-star{{ $i <= round($averageRating) ? ' active' : ' inactive' }}" style="color: {{ $i <= round($averageRating) ? 'var(--text-main)' : 'var(--border-color)' }};"></i>
                    @endfor
                    <span>({{ number_format($averageRating, 1) }} from {{ $reviewsCount }} reviews)</span>
                </div>

                <p class="product-desc">{{ $product->description }}</p>

                {{-- Add to Cart --}}
                <div class="add-to-cart-wrapper">
                    <div class="qty-selector">
                        <button type="button" onclick="decrementQty()">-</button>
                        <span id="quantity-display">1</span>
                        <button type="button" onclick="incrementQty()">+</button>
                        <input type="hidden" id="quantity-input" value="1" min="1" max="{{ $product->stock_quantity }}">
                    </div>
                    <button type="button" id="add-to-cart-btn"
                            class="btn btn-primary btn-add"
                            data-add-url="{{ route('cart.add', $product->id) }}"
                            onclick="addToCart(this)">Add to cart</button>
                </div>

                <div class="stock-status">
                    @if($product->stock_quantity > 0)
                        <i class="iconoir-check-circle"></i>
                        <span>In stock and ready to ship</span>
                    @else
                        <i class="iconoir-cancel"></i>
                        <span>Out of stock</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Product Details Accordion --}}
    <section class="product-details bg-light">
        <div class="container">
            <div class="accordion">
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <h3>Detailed description</h3>
                        <i class="iconoir-nav-arrow-down"></i>
                    </button>
                    <div class="accordion-content">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <h3>Specifications</h3>
                        <i class="iconoir-nav-arrow-down"></i>
                    </button>
                    <div class="accordion-content">
                        <p>
                            Material: {{ $product->material ?? '—' }}<br>
                            Origin: {{ $product->origin ?? '—' }}<br>
                            Color: {{ $product->color ?? '—' }}<br>
                            Care: Wipe clean with a damp cloth.
                        </p>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <h3>Shipping & returns</h3>
                        <i class="iconoir-nav-arrow-down"></i>
                    </button>
                    <div class="accordion-content">
                        <p>We offer complimentary carbon-neutral shipping on all orders over $300. Returns are accepted within 30 days of delivery in original, unused condition.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Visual Info Highlights --}}
    <section class="visual-info">
        <div class="container grid-12">
            <div class="highlight-item">
                <svg class="sketch-icon" viewBox="0 0 48 48" stroke="var(--text-main)" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 16 L23.5 25.5 L43.5 15.5" />
                    <path d="M4 16 L24 6.5 L44 15.5 M4 16 L4.5 32.5 L23.5 42 L43.5 32 L44 15.5" />
                    <path d="M23.5 25.5 L23.5 42" />
                    <path d="M4 16 L24 6.5 L44 15.5 L23.5 25.5 Z" fill="var(--accent-sand)" fill-opacity="0.15" stroke="none"/>
                </svg>
                <h3>Conscious delivery</h3>
                <p>Carbon-neutral shipping in fully recyclable, unbleached packaging.</p>
            </div>

            <div class="highlight-item">
                <svg class="sketch-icon" viewBox="0 0 48 48" stroke="var(--text-main)" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 22 C14 12, 16 6, 24 6 C32 6, 34 12, 34 22" />
                    <path d="M10 22 L38 21.5 L39 42 L9 42.5 Z" />
                    <circle cx="24" cy="32" r="2.5" />
                    <path d="M24 34.5 L24 38" />
                    <path d="M10 22 L38 21.5 L39 42 L9 42.5 Z" fill="var(--accent-sage)" fill-opacity="0.15" stroke="none"/>
                </svg>
                <h3>Secure transaction</h3>
                <p>Encrypted payment gateways ensuring your data remains private.</p>
            </div>

            <div class="highlight-item">
                <svg class="sketch-icon" viewBox="0 0 48 48" stroke="var(--text-main)" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 24 C12 16, 18 10, 26 10 C34 10, 38 16, 38 24 C38 32, 32 38, 22 38 C16 38, 11 34, 11 34" />
                    <path d="M11 26 L11 34 L19 34" />
                    <circle cx="24" cy="24" r="14" fill="var(--accent-terracotta)" fill-opacity="0.1" stroke="none" />
                </svg>
                <h3>Mindful returns</h3>
                <p>30-day return policy to ensure the piece fits your space perfectly.</p>
            </div>
        </div>
    </section>

    {{-- Reviews Section --}}
<section class="reviews container">
    <div class="review-header">
        <div>
            <h2>Client perspectives</h2>
            <p>Thoughts from those who live with our objects.</p>
        </div>
        @auth
            @if($canReview)
                <button class="btn btn-ghost" onclick="openReviewModal()">Write a review</button>
            @elseif($userReview)
                <span class="btn btn-ghost" style="opacity:0.6; cursor:default;">You already reviewed</span>
            @elseif(!$hasPurchased)
                <span class="btn btn-ghost" style="opacity:0.6; cursor:default;" title="Only verified buyers can review">🔒 Write a review</span>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost">Sign in to review</a>
        @endauth
    </div>

    <div class="review-list">
        @forelse($product->reviews as $review)
            <div class="review-item">
                <div class="review-meta">
                    <div>
                        <span class="review-author">{{ $review->user->name }}</span>
                        {{-- Verified purchase badge --}}
                        @php
                            $reviewerPurchased = $review->user->orders()
                                ->where('status', 'delivered')
                                ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
                                ->exists();
                        @endphp
                        @if($reviewerPurchased)
                            <span style="background: var(--accent-sage); color: white; font-size: 10px; padding: 2px 8px; border-radius: 20px; margin-left: 10px;">✓ VERIFIED BUYER</span>
                        @endif
                    </div>
                    <span class="review-date">{{ $review->created_at->format('F d, Y') }}</span>
                </div>
                <div class="rating" style="margin-bottom: 8px;">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="iconoir-star{{ $i <= $review->rating ? ' active' : '' }}" style="color: {{ $i <= $review->rating ? 'var(--text-main)' : 'var(--border-color)' }}; font-size: 14px;"></i>
                    @endfor
                </div>
                <p>"{{ $review->comment }}"</p>
            </div>
        @empty
            <p>No reviews yet. Be the first to share your thoughts.</p>
        @endforelse
    </div>
</section>

{{-- Review Modal --}}
@auth
@if($canReview)
<div id="reviewModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:var(--surface-color); padding:40px; border-radius:8px; max-width:500px; width:90%;">
        <h3>Share your perspective</h3>
        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
            @csrf
            <div style="margin:20px 0;">
                <label>Rating</label>
                <select name="rating" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:4px;">
                    <option value="5">★★★★★ (5)</option>
                    <option value="4">★★★★☆ (4)</option>
                    <option value="3">★★★☆☆ (3)</option>
                    <option value="2">★★☆☆☆ (2)</option>
                    <option value="1">★☆☆☆☆ (1)</option>
                </select>
            </div>
            <div style="margin:20px 0;">
                <label>Your thoughts</label>
                <textarea name="comment" rows="4" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:4px;"></textarea>
            </div>
            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn btn-primary">Submit review</button>
                <button type="button" class="btn btn-ghost" onclick="closeReviewModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endif
@endauth

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
    <section class="related container">
        <div class="section-header">
            <h2>Curated companions</h2>
        </div>
        <div class="related-products-grid">
            @foreach($relatedProducts as $related)
                <x-product-card :product="$related" />
            @endforeach
        </div>
    </section>
    @endif

    {{-- Review Modal (simplified) --}}
    @auth
    <div id="reviewModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:var(--surface-color); padding:40px; border-radius:8px; max-width:500px; width:90%;">
            <h3>Share your perspective</h3>
            {{-- {{ route('reviews.store', $product->id) }} --}}
            <form action="#" method="POST">
                @csrf
                <div style="margin:20px 0;">
                    <label>Rating</label>
                    <select name="rating" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:4px;">
                        <option value="5">★★★★★ (5)</option>
                        <option value="4">★★★★☆ (4)</option>
                        <option value="3">★★★☆☆ (3)</option>
                        <option value="2">★★☆☆☆ (2)</option>
                        <option value="1">★☆☆☆☆ (1)</option>
                    </select>
                </div>
                <div style="margin:20px 0;">
                    <label>Your thoughts</label>
                    <textarea name="comment" rows="4" required style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:4px;"></textarea>
                </div>
                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn btn-primary">Submit review</button>
                    <button type="button" class="btn btn-ghost" onclick="closeReviewModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endauth

</div>
@endsection

@push('scripts')
<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;

    // Quantity selector
    function incrementQty() {
        let input = document.getElementById('quantity-input');
        let display = document.getElementById('quantity-display');
        let max = parseInt(input.max);
        let val = parseInt(input.value);
        if (val < max) {
            input.value = val + 1;
            display.textContent = val + 1;
        }
    }

    function decrementQty() {
        let input = document.getElementById('quantity-input');
        let display = document.getElementById('quantity-display');
        let val = parseInt(input.value);
        if (val > 1) {
            input.value = val - 1;
            display.textContent = val - 1;
        }
    }

    async function addToCart(btn) {
        if (btn.disabled) return;
        btn.disabled = true;
        const qty = parseInt(document.getElementById('quantity-input').value) || 1;
        const originalText = btn.textContent;

        try {
            const res = await fetch(btn.dataset.addUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify({ quantity: qty }),
            });
            const data = await res.json();
            if (data.success) {
                btn.textContent = 'Added to cart ✓';
                btn.style.background = 'var(--accent-sage, #6b8f71)';
                btn.style.borderColor = 'var(--accent-sage, #6b8f71)';
                // update nav badge
                document.querySelectorAll('[data-cart-count]').forEach(el => {
                    el.textContent = data.cart_count;
                    el.dataset.cartCount = data.cart_count;
                });
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.background = '';
                    btn.style.borderColor = '';
                    btn.disabled = false;
                }, 2000);
            } else {
                btn.disabled = false;
            }
        } catch {
            btn.disabled = false;
        }
    }

    // Image gallery
    function changeMainImage(src) {
        document.querySelector('.main-image img').src = src;
    }

    // Accordion
    function toggleAccordion(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('i');
        const isOpen = content.style.maxHeight;

        document.querySelectorAll('.accordion-content').forEach(el => {
            el.style.maxHeight = null;
        });
        document.querySelectorAll('.accordion-header i').forEach(el => {
            el.style.transform = 'rotate(0deg)';
        });

        if (!isOpen) {
            content.style.maxHeight = content.scrollHeight + "px";
            icon.style.transform = 'rotate(180deg)';
            icon.style.transition = 'transform 0.3s ease';
        }
    }

    // Open first accordion by default
    document.addEventListener("DOMContentLoaded", () => {
        const firstButton = document.querySelector('.accordion-header');
        if(firstButton) toggleAccordion(firstButton);
    });

    // Review modal
    @auth
    function openReviewModal() {
        document.getElementById('reviewModal').style.display = 'flex';
    }
    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
    }
    @endauth
</script>
@endpush