@extends('layouts.app')

@section('title', 'Canned Tuna Collection — Aura Studio')

@section('content')
<section class="catalog-header container">
    <div class="breadcrumb">
        <a href="{{ url('/') }}">Home</a> <span>/</span>
        <a href="{{ route('shop.catalog') }}">Shop</a> <span>/</span>
        <span>All products</span>
    </div>
    <h1>Curated catch</h1>
    <p>Premium canned tuna — sourced from the world's finest fishing grounds and packed with care. Morocco, Spain, Japan, and beyond.</p>
</section>

<section class="shop-container container">

    <form id="filter-form" method="GET" action="{{ route('shop.catalog') }}">
        @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        @endif

        <aside class="sidebar">

            {{-- Active filter pills --}}
            @php
                $activeFilters = [];
                foreach((array) request('category', []) as $cid) {
                    $cat = $categories->firstWhere('id', $cid);
                    if ($cat) $activeFilters[] = ['label' => $cat->name, 'param' => 'category'];
                }
                foreach((array) request('origin', []) as $o) {
                    $activeFilters[] = ['label' => $o, 'param' => 'origin'];
                }
                foreach((array) request('material', []) as $m) {
                    $activeFilters[] = ['label' => $m, 'param' => 'material'];
                }
                if (request('price_min') || request('price_max')) {
                    $activeFilters[] = ['label' => '$' . (request('price_min') ?? '0') . '–$' . (request('price_max') ?? '∞'), 'param' => 'price'];
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

            {{-- Category Filter --}}
            <div class="filter-group">
                <div class="filter-group-header" onclick="toggleFilterGroup(this)">
                    <h3>Category
                        @if(count((array) request('category', [])))
                            <span class="filter-count">{{ count((array) request('category', [])) }}</span>
                        @endif
                    </h3>
                    <i class="iconoir-nav-arrow-down accordion-icon"></i>
                </div>
                <ul class="filter-list filter-group-content">
                    @foreach($categories as $category)
                        <label class="filter-item">
                            <input type="checkbox" name="category[]" value="{{ $category->id }}" class="filter-checkbox"
                                {{ in_array($category->id, (array) request('category', [])) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </ul>
            </div>

            {{-- Origin Filter --}}
            <div class="filter-group">
                <div class="filter-group-header" onclick="toggleFilterGroup(this)">
                    <h3>Origin
                        @if(count((array) request('origin', [])))
                            <span class="filter-count">{{ count((array) request('origin', [])) }}</span>
                        @endif
                    </h3>
                    <i class="iconoir-nav-arrow-down accordion-icon"></i>
                </div>
                <ul class="filter-list filter-group-content">
                    @foreach($origins as $origin)
                        <label class="filter-item">
                            <input type="checkbox" name="origin[]" value="{{ $origin }}" class="filter-checkbox"
                                {{ in_array($origin, (array) request('origin', [])) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span>{{ $origin }}</span>
                        </label>
                    @endforeach
                </ul>
            </div>

            {{-- Material Filter --}}
            <div class="filter-group collapsed">
                <div class="filter-group-header" onclick="toggleFilterGroup(this)">
                    <h3>Pack type
                        @if(count((array) request('material', [])))
                            <span class="filter-count">{{ count((array) request('material', [])) }}</span>
                        @endif
                    </h3>
                    <i class="iconoir-nav-arrow-down accordion-icon"></i>
                </div>
                <ul class="filter-list filter-group-content">
                    @foreach($materials as $material)
                        <label class="filter-item">
                            <input type="checkbox" name="material[]" value="{{ $material }}" class="filter-checkbox"
                                {{ in_array($material, (array) request('material', [])) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span>{{ $material }}</span>
                        </label>
                    @endforeach
                </ul>
            </div>

            {{-- Price Range Filter --}}
            <div class="filter-group collapsed">
                <div class="filter-group-header" onclick="toggleFilterGroup(this)">
                    <h3>Price range
                        @if(request('price_min') || request('price_max'))
                            <span class="filter-count">1</span>
                        @endif
                    </h3>
                    <i class="iconoir-nav-arrow-down accordion-icon"></i>
                </div>
                <div class="filter-group-content price-range-wrap">
                    <div class="price-range-display">
                        <span id="price-range-label">
                            ${{ number_format($filterPriceMin ?? $priceMin, 2) }} –
                            ${{ number_format($filterPriceMax ?? $priceMax, 2) }}
                        </span>
                    </div>
                    <div class="price-inputs">
                        <div class="price-input-group">
                            <label for="price_min">Min</label>
                            <input type="number" id="price_min" name="price_min"
                                   min="{{ floor($priceMin) }}" max="{{ ceil($priceMax) }}"
                                   step="0.50"
                                   value="{{ $filterPriceMin ?? '' }}"
                                   placeholder="{{ number_format($priceMin, 2) }}"
                                   class="price-input">
                        </div>
                        <span class="price-sep">—</span>
                        <div class="price-input-group">
                            <label for="price_max">Max</label>
                            <input type="number" id="price_max" name="price_max"
                                   min="{{ floor($priceMin) }}" max="{{ ceil($priceMax) }}"
                                   step="0.50"
                                   value="{{ $filterPriceMax ?? '' }}"
                                   placeholder="{{ number_format($priceMax, 2) }}"
                                   class="price-input">
                        </div>
                    </div>
                    <button type="submit" class="price-apply-btn">Apply</button>
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