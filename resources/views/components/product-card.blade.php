@props(['product'])

<article class="product-card">
    <a href="{{ route('shop.product', $product->slug) }}" class="product-link">
        <div class="product-image-container">
            {{-- Wishlist Button --}}
            @auth
                @php
                    $isWishlisted = $product->isWishlistedBy(auth()->user());
                @endphp
                <button class="wishlist-btn {{ $isWishlisted ? 'active' : '' }}" 
                        aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
                        data-product-id="{{ $product->id }}"
                        data-in-wishlist="{{ $isWishlisted ? 'true' : 'false' }}"
                        onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist(this, {{ $product->id }});">
                    <i class="iconoir-heart{{ $isWishlisted ? ' active' : '' }}"></i>
                </button>
            @endauth

            {{-- Product Image --}}
            @if($product->images && isset($product->images[0]))
                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" loading="lazy">
            @else
                <i class="iconoir-camera placeholder-icon"></i>
            @endif

            {{-- Quick Add Button (Form) --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="quick-add-form">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="quick-add-btn" aria-label="Quick add">
                    <i class="iconoir-plus"></i>
                </button>
            </form>
        </div>
        <div class="product-info">
            <h3 class="product-title">{{ $product->name }}</h3>
            <div class="product-meta">
                <span>{{ $product->material ?? 'Local Studio' }}, {{ $product->origin ?? 'Kyoto' }}</span>
                <span>${{ number_format($product->price, 0) }}</span>
            </div>
        </div>
    </a>
</article>