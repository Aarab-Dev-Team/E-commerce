@props(['product'])

<article class="product-card">
    <a href="{{ route('shop.product', $product->slug) }}" class="product-link">
        <div class="product-image-container">

            {{-- Wishlist Button --}}
            @auth
                @php
                    $isWishlisted = $product->isWishlistedBy(auth()->user());
                @endphp
                <button 
                    type="button"
                    class="wishlist-btn {{ $isWishlisted ? 'active' : '' }}"
                    aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
                    data-product-id="{{ $product->id }}"
                    data-in-wishlist="{{ $isWishlisted ? 'true' : 'false' }}"
                >
                    <i class="iconoir-heart{{ $isWishlisted ? ' active' : '' }}"></i>
                </button>
            @endauth

            {{-- Product Image --}}
            @if($product->images && isset($product->images[0]))
                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" loading="lazy">
            @else
                <i class="iconoir-camera placeholder-icon"></i>
            @endif

            {{-- Quick Add Button --}}
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

{{-- Wishlist Script --}}
@auth
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.wishlist-btn').forEach(button => {

        button.addEventListener('click', async function (e) {
            e.preventDefault();
            e.stopPropagation();

            const productId = this.dataset.productId;

            if (this.disabled) return;
            this.disabled = true;

            try {
                const response = await fetch(`/profile/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Request failed');
                }

                const data = await response.json();

                // update UI only
                if (data.added) {
                    this.classList.add('active');
                    this.querySelector('i').classList.add('active');
                    this.setAttribute('aria-label', 'Remove from wishlist');
                } else {
                    this.classList.remove('active');
                    this.querySelector('i').classList.remove('active');
                    this.setAttribute('aria-label', 'Add to wishlist');
                }

            } catch (error) {
                console.error(error);
            } finally {
                this.disabled = false;
            }
        });

    });

});
</script>
@endauth