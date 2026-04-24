@extends('layouts.admin')

@section('title', 'Categories — Aura. Admin')

@section('page-title', 'Categories')

@section('content')
<div class="page">
    <div class="section-header">
        <div>
            <h1>Taxonomy</h1>
            <p>Organize products into editorial collections and categories.</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('categoryModal')">+ Add category</button>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: var(--accent-sage); color: white; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: var(--accent-terracotta); color: white; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 24px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td><code style="font-size: 12px; color: var(--text-secondary);">/{{ $category->slug }}</code></td>
                    <td>{{ $category->products_count ?? 0 }}</td>
                    <td class="actions-cell">
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn-icon" onclick="editCategory({{ $category }})" title="Edit">
                                <i class="iconoir-edit-pencil"></i>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category? Products will have no category.');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" style="color: var(--accent-terracotta);" title="Delete">
                                    <i class="iconoir-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px;">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Include Modal --}}
@include('admin.categories.partials.modal')
@endsection

@push('scripts')
<script>
    // Pass categories data to JavaScript
    window.categories = @json($categories);

    function editCategory(category) {
        const form = document.getElementById('categoryForm');
        form.action = `/admin/categories/${category.id}`;
        form.querySelector('input[name="_method"]').value = 'PUT';
        form.querySelector('input[name="name"]').value = category.name;
        form.querySelector('input[name="slug"]').value = category.slug;
        document.querySelector('#categoryModal h2').innerText = 'Edit category';
        openModal('categoryModal');
    }

    // Reset modal when opening for new category
    document.querySelector('[onclick="openModal(\'categoryModal\')"]').addEventListener('click', function() {
        const form = document.getElementById('categoryForm');
        form.action = '{{ route("admin.categories.store") }}';
        form.querySelector('input[name="_method"]').value = 'POST';
        form.reset();
        document.querySelector('#categoryModal h2').innerText = 'Add category';
    });
</script>
@endpush