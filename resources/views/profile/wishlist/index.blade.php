@extends('layouts.profile')

@section('title', 'Wishlist — Aura Studio')

@push('styles')
    @vite(['resources/css/profile-wishlist.css'])
@endpush

@section('profile-content')
    <div class="page-header">
        <h1>Wishlist</h1>
        <p>Your curated collection of favorite pieces.</p>
    </div>

    @if($wishlistItems->isEmpty())
        <div class="empty-state">
            <i class="iconoir-heart"></i>
            <p>Your wishlist is empty.</p>
            <a href="{{ route('shop.catalog') }}" class="btn-filled">Explore objects</a>
        </div>
    @else
        <div class="wishlist-grid">
            @foreach($wishlistItems as $item)
                @php $product = $item->product; @endphp

                <article class="wishlist-card">

                    <form action="{{ route('profile.wishlist.destroy', $product) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to remove this item?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn-remove"
                                aria-label="Remove from wishlist">
                            <i class="iconoir-trash"></i>
                        </button>
                    </form>

                    <a href="{{ route('shop.product', $product->slug) }}" class="product-img-link">
                        @if($product->images && isset($product->images[0]))
                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}">
                        @else
                            <i class="iconoir-camera"></i>
                        @endif
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
@endsection