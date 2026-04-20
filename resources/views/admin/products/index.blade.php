@extends('layouts.admin')

@section('title', 'Products — Aura. Admin')

@section('page-title', 'Products')

@section('content')
<div class="page">
    <div class="section-header">
        <div>
            <h1>Product catalog</h1>
            <p>Manage inventory, pricing, and details.</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('productModal')">+ Add product</button>
    </div>

    {{-- Search and Filter --}}
    <form method="GET" action="{{ route('admin.products.index') }}" style="display: flex; gap: 24px; margin-bottom: 24px;">
        <div class="search-container" style="width: 300px; border-bottom: 1px solid var(--border-subtle);">
            <i class="iconoir-search"></i>
            <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}">
        </div>
        <select name="category" onchange="this.form.submit()" style="width: 200px; padding-bottom: 4px;">
            <option value="">All categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-ghost" style="padding: 6px 16px;">Filter</button>
    </form>

    {{-- Products Table --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="prod-thumb">
                            @if($product->images && isset($product->images[0]))
                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            @endif
                        </div>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        <span class="badge {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $product->is_active ? 'active' : 'inactive' }}
                        </span>
                    </td>
                    <td class="actions-cell">
                        <i class="iconoir-edit action-icon" onclick="editProduct({{ $product }})"></i>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; padding: 0;">
                                <i class="iconoir-trash action-icon"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination">
        {{ $products->links('pagination.admin') }}
    </div>
</div>

{{-- Include Modal --}}
@include('admin.products.partials.modal')
@endsection

@push('scripts')
<script>
    // Pass categories to JavaScript for the modal dropdown
    window.categories = @json($categories);

    function editProduct(product) {
        // Populate the modal form with product data
        const form = document.getElementById('productForm');
        form.action = `/admin/products/${product.id}`;
        form.querySelector('input[name="_method"]').value = 'PATCH';

        for (let field in product) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                if (input.type === 'checkbox') {
                    input.checked = product[field];
                } else {
                    input.value = product[field] || '';
                }
            }
        }
        // Set category
        const categorySelect = form.querySelector('[name="category_id"]');
        if (categorySelect) categorySelect.value = product.category_id;

        document.querySelector('#productModal h2').innerText = 'Edit product';
        openModal('productModal');
    }

    // Reset modal when opening for new product
    document.querySelector('[onclick="openModal(\'productModal\')"]').addEventListener('click', function() {
        const form = document.getElementById('productForm');
        form.action = '{{ route("admin.products.store") }}';
        form.querySelector('input[name="_method"]').value = 'POST';
        form.reset();
        document.querySelector('#productModal h2').innerText = 'Add new product';
    });
</script>
@endpush