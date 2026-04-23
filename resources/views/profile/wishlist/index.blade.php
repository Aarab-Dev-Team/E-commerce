@extends('layouts.profile')

@section('title', 'Wishlist — Aura Studio')

@push('styles')
    @vite(['resources/css/profile-wishlist.css'])
@endpush

@section('profile-content')

    {{-- Header --}}
    <div class="wishlist-page-header">
        <div class="wishlist-page-header__text">
            <h1>Wishlist</h1>
            <p>Your curated collection of favourite pieces.</p>
        </div>
        @if(!$wishlistItems->isEmpty())
            <span class="wishlist-count-badge">{{ $wishlistItems->count() }} {{ Str::plural('item', $wishlistItems->count()) }}</span>
        @endif
    </div>

    @if($wishlistItems->isEmpty())

        {{-- Empty State --}}
        <div class="wl-empty">
            <div class="wl-empty__icon">
                <i class="iconoir-heart"></i>
            </div>
            <h2>Nothing saved yet</h2>
            <p>Explore the collection and save the pieces that speak to you.</p>
            <a href="{{ route('shop.catalog') }}" class="btn-outline" style="margin-top: 16px;">
                Explore objects
            </a>
        </div>

    @else

        <div class="wishlist-grid" id="wishlist-grid">
            @foreach($wishlistItems as $item)
                @php $product = $item->product; @endphp

                <article class="wl-card" id="wl-card-{{ $product->id }}" data-product-id="{{ $product->id }}">

                    {{-- Image --}}
                    <a href="{{ route('shop.product', $product->slug) }}" class="wl-card__image">
                        @if($product->images && isset($product->images[0]))
                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <i class="iconoir-camera wl-card__placeholder"></i>
                        @endif

                        {{-- Hover overlay with quick-add --}}
                        <div class="wl-card__overlay">
                            <button type="button"
                                    class="wl-card__add-btn"
                                    aria-label="Add to cart"
                                    data-add-url="{{ route('cart.add', $product->id) }}"
                                    onclick="wishlistAddToCart(this, event)">
                                <i class="iconoir-shopping-bag"></i>
                                <span>Add to cart</span>
                            </button>
                        </div>
                    </a>

                    {{-- Remove button --}}
                    <button type="button"
                            class="wl-card__remove"
                            aria-label="Remove from wishlist"
                            data-remove-url="{{ route('profile.wishlist.destroy', $product) }}"
                            onclick="wishlistRemove(this)">
                        <i class="iconoir-xmark"></i>
                    </button>

                    {{-- Info --}}
                    <div class="wl-card__info">
                        <a href="{{ route('shop.product', $product->slug) }}" class="wl-card__name">
                            {{ $product->name }}
                        </a>
                        <div class="wl-card__meta">
                            @if($product->material)
                                <span class="wl-card__material">{{ $product->material }}</span>
                            @endif
                            <span class="wl-card__price">${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>

                </article>
            @endforeach
        </div>

    @endif

@endsection

{{-- Remove confirmation dialog --}}
<div id="wl-confirm-dialog" class="wl-dialog-backdrop" aria-modal="true" role="dialog" aria-labelledby="wl-dialog-title" style="display:none;">
    <div class="wl-dialog">
        <div class="wl-dialog__icon">
            <i class="iconoir-trash"></i>
        </div>
        <h3 id="wl-dialog-title">Remove from wishlist?</h3>
        <p>This product will be removed from your saved collection.</p>
        <div class="wl-dialog__actions">
            <button type="button" class="wl-dialog__cancel" onclick="wlDialogCancel()">Keep it</button>
            <button type="button" class="wl-dialog__confirm" onclick="wlDialogConfirm()">Remove</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
const WL_CSRF = document.querySelector('meta[name="csrf-token"]')?.content;

// ── Confirmation dialog state ───────────────────────────────────────────────
let _pendingRemoveBtn = null;

function wishlistRemove(btn) {
    if (btn.disabled) return;
    _pendingRemoveBtn = btn;
    const dialog = document.getElementById('wl-confirm-dialog');
    dialog.style.display = 'flex';
    // slight delay so the display change registers before the animation
    requestAnimationFrame(() => dialog.classList.add('wl-dialog-backdrop--visible'));
}

function wlDialogCancel() {
    const dialog = document.getElementById('wl-confirm-dialog');
    dialog.classList.remove('wl-dialog-backdrop--visible');
    setTimeout(() => { dialog.style.display = 'none'; }, 220);
    _pendingRemoveBtn = null;
}

async function wlDialogConfirm() {
    const btn  = _pendingRemoveBtn;
    if (!btn) return;
    _pendingRemoveBtn = null;

    // close dialog first
    wlDialogCancel();

    btn.disabled = true;
    const card = btn.closest('.wl-card');
    const url  = btn.dataset.removeUrl;

    try {
        const res = await fetch(url, {
            method : 'POST',
            headers: {
                'Content-Type' : 'application/json',
                'Accept'       : 'application/json',
                'X-CSRF-TOKEN' : WL_CSRF,
                'X-HTTP-Method-Override': 'DELETE',
            },
            body: JSON.stringify({ _method: 'DELETE' }),
        });

        if (res.ok) {
            card.style.transition = 'opacity 0.3s, transform 0.3s';
            card.style.opacity    = '0';
            card.style.transform  = 'scale(0.96)';
            setTimeout(() => {
                card.remove();
                const grid = document.getElementById('wishlist-grid');
                if (grid && grid.querySelectorAll('.wl-card').length === 0) {
                    location.reload();
                }
                const badge = document.querySelector('.wishlist-count-badge');
                if (badge) {
                    const remaining = document.querySelectorAll('.wl-card').length;
                    badge.textContent = remaining + ' ' + (remaining === 1 ? 'item' : 'items');
                }
            }, 300);
        } else {
            btn.disabled = false;
        }
    } catch {
        btn.disabled = false;
    }
}

// close on backdrop click or Escape key
document.addEventListener('click', e => {
    if (e.target.id === 'wl-confirm-dialog') wlDialogCancel();
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') wlDialogCancel();
});

async function wishlistAddToCart(btn, e) {
    e.preventDefault();
    e.stopPropagation();
    if (btn.disabled) return;
    btn.disabled = true;

    const icon = btn.querySelector('i');
    const text = btn.querySelector('span');

    try {
        const res  = await fetch(btn.dataset.addUrl, {
            method : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept'      : 'application/json',
                'X-CSRF-TOKEN': WL_CSRF,
            },
            body: JSON.stringify({ quantity: 1 }),
        });
        const data = await res.json();

        if (data.success) {
            if (icon) icon.className = 'iconoir-check';
            if (text) text.textContent = 'Added!';
            btn.classList.add('added');

            // update nav badge
            document.querySelectorAll('[data-cart-count]').forEach(el => {
                el.textContent = data.cart_count;
                el.dataset.cartCount = data.cart_count;
            });

            setTimeout(() => {
                if (icon) icon.className = 'iconoir-shopping-bag';
                if (text) text.textContent = 'Add to cart';
                btn.classList.remove('added');
                btn.disabled = false;
            }, 2000);
        } else {
            btn.disabled = false;
        }
    } catch {
        btn.disabled = false;
    }
}
</script>
@endpush