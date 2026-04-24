@extends('layouts.profile')

@section('title', 'Wishlist — Aura Studio')

@push('styles')
    @vite(['resources/css/profile-wishlist.css'])
    <style>
        /* ── Remove-button loading state ── */
        .btn-remove.is-loading { opacity: .5; pointer-events: none; }

        /* ── Wishlist card exit animation ── */
        .wishlist-card.is-removing {
            animation: wl-card-out 350ms ease forwards;
        }
        @keyframes wl-card-out {
            from { opacity: 1; transform: scale(1); }
            to   { opacity: 0; transform: scale(.92); }
        }

        /* ── Toast notification ── */
        #wl-toast {
            position: fixed;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: var(--text-main, #1A1A18);
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: .9rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 300ms ease, transform 300ms ease;
            z-index: 9999;
        }
        #wl-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    </style>
@endpush

@section('profile-content')
    <div class="page-header">
        <h1>Wishlist</h1>
        <p>Your curated collection of favorite pieces.</p>
    </div>

    @if($wishlistItems->isEmpty())
        <div class="empty-state" id="wl-empty-state">
            <i class="iconoir-heart"></i>
            <p>Your wishlist is empty.</p>
            <a href="{{ route('shop.catalog') }}" class="btn-filled">Explore objects</a>
        </div>
    @else
        {{-- Hidden empty-state (shown via JS when last card is removed) --}}
        <div class="empty-state" id="wl-empty-state" style="display:none;">
            <i class="iconoir-heart"></i>
            <p>Your wishlist is empty.</p>
            <a href="{{ route('shop.catalog') }}" class="btn-filled">Explore objects</a>
        </div>

        <div class="wishlist-grid" id="wl-grid">
            @foreach($wishlistItems as $item)
                @php $product = $item->product; @endphp

                <article class="wishlist-card" id="wl-card-{{ $product->id }}">

                    <button type="button"
                            class="btn-remove"
                            aria-label="Remove from wishlist"
                            data-url="{{ route('profile.wishlist.destroy', $product) }}"
                            data-product-id="{{ $product->id }}"
                            onclick="wishlistRemove(this)">
                        <i class="iconoir-trash"></i>
                    </button>

                    <a href="{{ route('shop.product', $product->slug) }}" class="product-img-link">
                        @if($product->images && isset($product->images[0]))
                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}">
                        @else
                            <i class="iconoir-camera"></i>
                        @endif
                        {{-- Hover overlay with quick-add --}}
                        <div class="wl-card__overlay">
                            <button type="button"
                                    class="wl-card__add-btn"
                                    aria-label="Add to cart"
                                    data-add-url="{{ route('cart.add', $product->id) }}"
                                    onclick="wishlistAddToCart(this, event)">
                                <i class="iconoir-shopping-bag"></i>
                                <span class="wl-card__add-text">Add to cart</span>
                            </button>
                        </div>
                    </a>

                    <div class="product-info">
                        <h3 class="product-title">
                            <a href="{{ route('shop.product', $product->slug) }}">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <span class="product-price">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    </div>

                </article>
            @endforeach
        </div>
    @endif

    {{-- Global toast element --}}
    <div id="wl-toast"></div>
@endsection

@push('scripts')
<script>
    /* ─── Wishlist AJAX Remove ──────────────────────────────── */
    async function wishlistRemove(btn) {
        const url       = btn.dataset.url;
        const productId = btn.dataset.productId;
        const card      = document.getElementById('wl-card-' + productId);

        btn.classList.add('is-loading');

        try {
            const res = await fetch(url, {
                method : 'DELETE',
                headers: {
                    'Accept'      : 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            const data = await res.json();

            if (res.ok && data.success) {
                /* Animate card out, then remove from DOM */
                card.classList.add('is-removing');
                card.addEventListener('animationend', () => {
                    card.remove();

                    /* If grid is now empty, show the empty state */
                    const grid = document.getElementById('wl-grid');
                    if (grid && grid.querySelectorAll('.wishlist-card').length === 0) {
                        grid.remove();
                        document.getElementById('wl-empty-state').style.display = '';
                    }
                }, { once: true });

                showWlToast(data.message || 'Removed from wishlist');
            } else {
                showWlToast(data.message || 'Something went wrong', true);
                btn.classList.remove('is-loading');
            }
        } catch (err) {
            console.error(err);
            showWlToast('Network error — please try again.', true);
            btn.classList.remove('is-loading');
        }
    }

    /* ─── Toast helper ──────────────────────────────────────── */
    let _toastTimer;
    function showWlToast(msg, isError = false) {
        const toast = document.getElementById('wl-toast');
        toast.textContent = msg;
        toast.style.background = isError ? '#c0392b' : 'var(--text-main, #1A1A18)';
        toast.classList.add('show');
        clearTimeout(_toastTimer);
        _toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
    }

    /* ─── Add to cart from wishlist (quick-add overlay) ────── */
    async function wishlistAddToCart(btn, event) {
        event.preventDefault();
        event.stopPropagation();

        const url = btn.dataset.addUrl;
        btn.disabled = true;

        try {
            const res = await fetch(url, {
                method : 'POST',
                headers: {
                    'Accept'      : 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            const data = await res.json();

            if (res.ok && data.success !== false) {
                showWlToast('Added to cart ✓');

                /* Update cart badge if present in the DOM */
                const badge = document.querySelector('[data-cart-count]');
                if (badge && data.cartCount !== undefined) {
                    badge.textContent = data.cartCount;
                }
            } else {
                showWlToast(data.message || 'Could not add to cart', true);
            }
        } catch (err) {
            console.error(err);
            showWlToast('Network error — please try again.', true);
        } finally {
            btn.disabled = false;
        }
    }
</script>
@endpush