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
    <form method="GET" action="{{ route('admin.products.index') }}" style="display: flex; gap: 24px; margin-bottom: 24px; flex-wrap: wrap;">
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
        <select name="pending" onchange="this.form.submit()" style="width: 200px; padding-bottom: 4px;">
            <option value="">All statuses</option>
            <option value="pending_creation"  {{ request('pending') === 'pending_creation'  ? 'selected' : '' }}>Pending creation</option>
            <option value="pending_update"    {{ request('pending') === 'pending_update'    ? 'selected' : '' }}>Pending update</option>
            <option value="pending_deletion"  {{ request('pending') === 'pending_deletion'  ? 'selected' : '' }}>Pending deletion</option>
            <option value="approved"          {{ request('pending') === 'approved'          ? 'selected' : '' }}>Approved</option>
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
                                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            @endif
                        </div>
                    </td>
                    <td style="font-weight: 500;">{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        {{-- Combined status badge --}}
                        @php
                            $ps = $product->pending_status;
                            $statusLabel = match($ps) {
                                'pending_creation' => 'Pending creation',
                                'pending_update'   => 'Pending update',
                                'pending_deletion' => 'Pending deletion',
                                default            => $product->is_active ? 'Active' : 'Inactive',
                            };
                            $statusClass = match($ps) {
                                'pending_creation' => 'badge-creation',
                                'pending_update'   => 'badge-update',
                                'pending_deletion' => 'badge-deletion',
                                default            => $product->is_active ? 'badge-active' : 'badge-inactive',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td class="actions-cell">
                        {{-- Edit --}}
                        <i class="iconoir-edit action-icon" onclick="editProduct({{ $product }})" title="Edit"></i>

                        {{-- Delete / Submit for deletion --}}
                        @if($product->pending_status === 'pending_deletion')
                            <span style="color: var(--text-muted); font-size: 12px;">Awaiting deletion</span>
                        @else
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('{{ auth()->user()->role === 'admin' ? 'Permanently delete this product?' : 'Submit deletion request for admin approval?' }}')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;" title="{{ auth()->user()->role === 'admin' ? 'Delete' : 'Request deletion' }}">
                                    <i class="iconoir-trash action-icon"></i>
                                </button>
                            </form>
                        @endif

                        {{-- Admin-only: Approve/Reject inline for pending items --}}
                        @if(auth()->user()->role === 'admin' && $product->pending_status !== 'approved')
                            <form action="{{ route('admin.approvals.approve', $product) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-icon approve" title="Approve" style="margin-left: 4px;">
                                    <i class="iconoir-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.approvals.reject', $product) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-icon reject" title="Reject">
                                    <i class="iconoir-xmark"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">No products found.</td>
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
    window.categories = @json($categories);

    function editProduct(product) {
        const form = document.getElementById('productForm');
        form.action = `/admin/products/${product.id}`;
        form.querySelector('input[name="_method"]').value = 'PATCH';

        const fields = ['name', 'slug', 'description', 'price', 'stock_quantity', 'category_id', 'origin', 'material', 'color'];
        fields.forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) input.value = product[field] || '';
        });

        // Category select
        const categorySelect = form.querySelector('[name="category_id"]');
        if (categorySelect) categorySelect.value = product.category_id;

        // is_active (admin only)
        const isActiveSelect = form.querySelector('[name="is_active"]');
        if (isActiveSelect) isActiveSelect.value = product.is_active ? '1' : '0';

        document.querySelector('#productModal h2').innerText = 'Edit product';
        document.querySelector('#productModal p').innerText = 'Update details for this catalog item.';
        openModal('productModal');
    }

    // Reset modal when opening for new product
    document.querySelector('[onclick="openModal(\'productModal\')"]').addEventListener('click', function () {
        const form = document.getElementById('productForm');
        form.action = '{{ route("admin.products.store") }}';
        form.querySelector('input[name="_method"]').value = 'POST';
        form.reset();
        document.querySelector('#productModal h2').innerText = 'Add new product';
        document.querySelector('#productModal p').innerText = '{{ auth()->user()->role === "admin" ? "Enter details for the new catalog item." : "Submit a new product for admin approval." }}';
    });
</script>
@endpush