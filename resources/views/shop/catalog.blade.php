@extends('layouts.app')

@section('title', 'Canned Tuna Collection — Aura Studio')

@section('content')
<section class="page-header container">
    <div class="breadcrumb">
        <a href="{{ url('/') }}">Home</a> <span>/</span>
        <a href="{{ route('shop.catalog') }}">Shop</a> <span>/</span>
        <span>All products</span>
    </div>
    <h1>Curated catch</h1>
    <p>Premium canned tuna — sourced from the world's finest fishing grounds and packed with care. Morocco, Spain, Japan, and beyond.</p>
    <svg class="decor-svg" xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 64 64"><path fill="#1B1B0D" d="M28.8 14.7c.6.2 1.8.2 2.5 0 .6-.3.1-.5-1.3-.5s-1.9.2-1.2.5M12 25.5c-1.2 1.3-2.8 2.2-3.4 1.8-.6-.3-.8-.3-.4.2.4.4.3 1.4-.3 2.2-.6.7-.8 1.3-.3 1.2.5 0 2.4-1.8 4.3-4 3.7-4.3 3.8-5.3.1-1.4m15.1.9c.2.2 1.5.9 2.9 1.5 2.4 1.1 2.4 1.1.6-.3-1.6-1.3-4.9-2.4-3.5-1.2M10.8 50c-.3 1.7-.1 3 .4 3 .4 0 .8-1.4.8-3 0-1.7-.2-3-.4-3s-.6 1.3-.8 3"/><path fill="#0D0D0D" d="M39.5 12c-1.1.5-3.6.9-5.5 1-3.2.2-3.3.3-1 1 4.7 1.5 7.7 1.1 8.3-1 .3-1.1.4-2 .4-1.9-.1 0-1.1.4-2.2.9m-16.8 8.7c-.3.5 2.8.8 6.9.8s6.6-.3 5.7-.7c-2.4-.9-12.1-1-12.6-.1M28 26c4 2.2 6.6 2.5 7.6.9 1-1.7-1.6-2.9-6.6-2.8h-4.5zm-10.3 9.8c-1.9.2-3.1 1.2-3.7 2.8s-1.6 2.4-2.7 2.2c-1.5-.2-1.8.5-2 4.2 0 2.5.3 5.2.8 6 .8 1.2.9 1.1.7-.5-.6-3.7 3.5-9.7 8.1-12.1 4.4-2.2 3.9-3.2-1.2-2.6M32.5 37c-.3.5.3 1 1.4 1 1.2 0 2.1-.5 2.1-1 0-.6-.6-1-1.4-1s-1.8.4-2.1 1"/><path fill="#1B0D0D" d="M24.7 25.1c.7.7 1.5 1 1.8.7s-.2-.9-1.2-1.2c-1.4-.6-1.5-.5-.6.5"/><path fill="#281B0D" d="M37.5 22c-.3.6.1.7.9.4 1.8-.7 2.1-1.4.7-1.4-.6 0-1.3.4-1.6 1m-10.7 1.7c1.2.2 3.2.2 4.5 0 1.2-.2.2-.4-2.3-.4s-3.5.2-2.2.4M13.1 38.6c0 1.1.3 1.4.6.6.3-.7.2-1.6-.1-1.9-.3-.4-.6.2-.5 1.3"/><g fill="#E4431B" stroke-width="0"><path d="M26 15.9c-5.1 1.1-10.4 3.8-13.1 6.9-2.1 2.4-2.1 2.5-.2.8 5.8-4.8 17.4-5.9 27.4-2.6 3.3 1.1 6.4 1.8 7 1.5 1.7-1.1.9.4-1.6 2.9-1.4 1.4-2.5 3.1-2.5 3.9 0 1.7 5.5 6.7 7.3 6.7 2.1 0 2.8-1.2 1.6-2.7-1.4-1.6-.5-1.7 2.2-.3 1.4.8 2.6.7 4.5-.3l2.5-1.3-4.9-4.6c-5.8-5.5-12.7-9.1-20-10.7-2.9-.6-5.6-1-6-1-.4.1-2.3.4-4.2.8M55 28c0 .5-.7 1-1.6 1-.8 0-1.2-.5-.9-1 .3-.6 1-1 1.6-1 .5 0 .9.4.9 1"/><path d="M18.6 23.5C10.7 26.3 6.1 34.4 10.5 38c1.3 1.1 1.5.7 1.5-2.9 0-3.2.5-4.4 2.4-5.6 2.9-1.9 5-1.5 16.3 3.1 5.2 2.2 9.8 3.4 12.5 3.3 3.6 0 3.9-.2 2-.9-1.3-.6-2.9-2.4-3.7-4.2S40.1 28.2 40 29c0 .9.7 2.6 1.6 3.8 1.6 2.3.4 3.2-1.3.9-1.9-2.4-2.1-4.5-.8-7 1.2-2.3 1.1-2.6-.8-3.1-1.2-.3-2.3-.3-2.6-.1-.2.3.1.5.7.5 2.1 0 1.3 2.9-1.4 4.6-2.4 1.6-2.8 1.6-7-.4-2.4-1.2-5.2-2.2-6-2.2-2.6 0-.9-2.5 2.2-3.1 2.7-.6 2.7-.7.4-.7-1.4-.1-4.2.5-6.4 1.3"/></g><path fill="#1B1B0D" fill-opacity=".74" d="M12.8 16.7c.7.3 1.6.2 1.9-.1.4-.3-.2-.6-1.3-.5-1.1 0-1.4.3-.6.6"/><path fill="#511B1B" d="M11.8 19.7c.7.3 1.6.2 1.9-.1.4-.3-.2-.6-1.3-.5-1.1 0-1.4.3-.6.6"/><path fill="#AE361B" d="M42.3 33.5c0 .8.4 1.2.9.9s.6-1 .3-1.5c-.9-1.3-1.2-1.1-1.2.6"/><path fill="#361B0D" fill-opacity=".99" d="M58 27.4c0 .2.8 1 1.8 1.7 1.5 1.3 1.6 1.2.3-.4S58 26.6 58 27.4"/></svg>
</section>

<section class="shop-container container">

    <form id="filter-form" method="GET" action="{{ route('shop.catalog') }}">
        @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        @endif

        <aside class="sidebar">

    {{-- 1. Active Filters --}}
    @php
        $activeFilters = [];
        foreach((array) request('category', []) as $cid) {
            $cat = $categories->firstWhere('id', $cid);
            if ($cat) $activeFilters[] = ['label' => $cat->name];
        }
        foreach((array) request('origin', []) as $o) { $activeFilters[] = ['label' => $o]; }
        foreach((array) request('material', []) as $m) { $activeFilters[] = ['label' => $m]; }
        if (request('price_min') || request('price_max')) {
            $activeFilters[] = ['label' => '$' . (request('price_min') ?? '0') . '–$' . (request('price_max') ?? '∞')];
        }
    @endphp

    @if(count($activeFilters))
    <div class="active-filters">
        <span class="filter-label-sm">Active filters</span>
        <div class="filter-pills">
            @foreach($activeFilters as $af)
                <span class="filter-pill">{{ $af['label'] }}</span>
            @endforeach
            <a href="{{ route('shop.catalog') }}" class="filter-clear">Clear all</a>
        </div>
    </div>
    @endif

    {{-- 2. Category Filter --}}
    <div class="filter-group">
        <div class="filter-group-header" onclick="this.parentElement.classList.toggle('collapsed')">
            <h3>Category
                @if(count((array) request('category', [])))
                    <span class="filter-count">({{ count((array) request('category', [])) }})</span>
                @endif
            </h3>
            <i class="iconoir-nav-arrow-down accordion-icon"></i>
        </div>
        <div class="filter-group-content">
            <ul class="filter-list">
                @foreach($categories as $category)
                    <li>
                        <label class="filter-item">
                            <input type="checkbox" name="category[]" value="{{ $category->id }}" class="filter-checkbox"
                                {{ in_array($category->id, (array) request('category', [])) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span>{{ $category->name }}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- 3. Origin Filter --}}
    <div class="filter-group">
        <div class="filter-group-header" onclick="this.parentElement.classList.toggle('collapsed')">
            <h3>Origin
                @if(count((array) request('origin', [])))
                    <span class="filter-count">({{ count((array) request('origin', [])) }})</span>
                @endif
            </h3>
            <i class="iconoir-nav-arrow-down accordion-icon"></i>
        </div>
        <div class="filter-group-content">
            <ul class="filter-list">
                @foreach($origins as $origin)
                    <li>
                        <label class="filter-item">
                            <input type="checkbox" name="origin[]" value="{{ $origin }}" class="filter-checkbox"
                                {{ in_array($origin, (array) request('origin', [])) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span>{{ $origin }}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- 4. Price Range Filter --}}
    <div class="filter-group collapsed">
        <div class="filter-group-header" onclick="this.parentElement.classList.toggle('collapsed')">
            <h3>Price range</h3>
            <i class="iconoir-nav-arrow-down accordion-icon"></i>
        </div>
        <div class="filter-group-content price-range-wrap">
            <div class="price-range-display">
                <span>
                    ${{ number_format($filterPriceMin ?? $priceMin, 2) }} — 
                    ${{ number_format($filterPriceMax ?? $priceMax, 2) }}
                </span>
            </div>
            <div class="price-inputs">
                <div class="price-input-group">
                    <label>Min</label>
                    <input type="number" name="price_min" value="{{ $filterPriceMin ?? '' }}" placeholder="{{ floor($priceMin) }}" class="price-input">
                </div>
                <div class="price-input-group">
                    <label>Max</label>
                    <input type="number" name="price_max" value="{{ $filterPriceMax ?? '' }}" placeholder="{{ ceil($priceMax) }}" class="price-input">
                </div>
            </div>
            <button type="submit" class="price-apply-btn">Apply range</button>
        </div>
    </div>

</aside>
    </form>

    <div class="products-area">
        <div class="sorting-bar">
            <div class="results-count">
                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
            </div>
            <div class="sort-dropdown">
                <label for="sort">Sort by:</label>
                <select id="sort" name="sort" onchange="this.form.submit()" form="filter-form">
                    <option value="latest"     {{ request('sort') == 'latest'     ? 'selected' : '' }}>Curated selection</option>
                    <option value="newest"     {{ request('sort') == 'newest'     ? 'selected' : '' }}>Newest arrivals</option>
                    <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Price: low to high</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: high to low</option>
                </select>
            </div>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="no-results">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="22" cy="22" r="15" stroke="#6B6A66" stroke-width="1.2" fill="none"/>
                        <path d="M33 33 L43 43" stroke="#6B6A66" stroke-width="1.2" stroke-linecap="round"/>
                        <path d="M17 22 L27 22 M22 17 L22 27" stroke="#6B6A66" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                    <p>No products match your filters.</p>
                    <a href="{{ route('shop.catalog') }}" class="btn-link">Clear all filters</a>
                </div>
            @endforelse
        </div>

        {{ $products->withQueryString()->links('pagination.custom') }}
    </div>
</section>
@endsection

@push('scripts')
<script>
    function toggleFilterGroup(header) {
        const group = header.closest('.filter-group');
        group.classList.toggle('collapsed');
        const icon = header.querySelector('.accordion-icon');
        icon.style.transform = group.classList.contains('collapsed') ? 'rotate(-90deg)' : '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.filter-group.collapsed .accordion-icon').forEach(icon => {
            icon.style.transform = 'rotate(-90deg)';
        });
    });
</script>
@endpush