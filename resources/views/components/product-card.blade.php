@props(['product'])

<article class="product-card">
    <a href="{{ route('shop.product', $product->slug) }}" style="display: block; text-decoration: none; color: inherit;">
        <div class="product-image-container">
            @if($product->images && isset($product->images[0]))
                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" loading="lazy">
            @else
                <i class="iconoir-camera placeholder-icon"></i>
            @endif
            <button class="quick-add-btn" aria-label="Quick add"
                    data-product-id="{{ $product->id }}"
                    onclick="event.preventDefault(); event.stopPropagation(); quickAdd({{ $product->id }})">
                <i class="iconoir-plus"></i>
            </button>
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