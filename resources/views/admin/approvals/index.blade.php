@extends('layouts.admin')

@section('title', 'Pending Approvals — Aura. Admin')

@section('page-title', 'Approvals')

@push('styles')
    {{-- Additional styles are already in admin.css --}}
@endpush

@section('content')
<div class="page">
    <div class="section-header" style="align-items: flex-start;">
        <div>
            <h1 style="display: flex; align-items: center;">
                Pending Product Approvals 
                <span class="count-badge">{{ $products->total() }}</span>
            </h1>
            <p>Review and approve changes submitted by employees.</p>
        </div>
        <div class="hero-art">
            <svg class="organic-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path class="fill-path" d="M30,35 C35,32 50,33 55,40 C60,48 55,60 45,65 C35,70 25,65 20,55 C15,45 20,38 30,35 Z" />
                <path class="stroke-path" d="M40,20 L75,20 C80,20 85,25 85,30 L85,80 C85,85 80,90 75,90 L25,90 C20,90 15,85 15,80 L15,45 Z" />
                <path class="stroke-path" d="M15,45 L40,20 L40,40 C40,43 37,45 35,45 L15,45" />
                <path class="stroke-path" d="M35,60 L50,75 L70,50" />
            </svg>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tabs" style="margin-bottom: 32px;">
        <a href="{{ route('admin.approvals.index') }}" class="tab {{ !request('type') ? 'active' : '' }}">All requests</a>
        <a href="{{ route('admin.approvals.index', ['type' => 'creation']) }}" class="tab {{ request('type') == 'creation' ? 'active' : '' }}">Creations</a>
        <a href="{{ route('admin.approvals.index', ['type' => 'update']) }}" class="tab {{ request('type') == 'update' ? 'active' : '' }}">Updates</a>
        <a href="{{ route('admin.approvals.index', ['type' => 'deletion']) }}" class="tab {{ request('type') == 'deletion' ? 'active' : '' }}">Deletions</a>
    </div>

    {{-- Table --}}
    <div class="card table-wrapper" style="padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Request type</th>
                    <th>Submitted by</th>
                    <th>Date</th>
                    <th>Changes summary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                @php
                    $employee = $product->user ?? null;
                @endphp
                <tr>
                    <td>
                        <div class="product-cell" style="display: flex; align-items: center; gap: 12px;">
                            <div class="avatar-img" style="width: 32px; height: 32px; border-radius: 4px; background: var(--bg-base); display: flex; align-items: center; justify-content: center;">
                                @if($product->images && isset($product->images[0]))
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                                @else
                                    <i class="iconoir-image" style="color: var(--text-muted);"></i>
                                @endif
                            </div>
                            <span class="cell-title">
                                {{ $product->name ?? 'New Product' }}
                                @if($product->pending_status == 'pending_creation')
                                    (New)
                                @endif
                            </span>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge badge-{{ str_replace('pending_', '', $product->pending_status) }}">
                            {{ ucfirst(str_replace('pending_', '', $product->pending_status)) }}
                        </span>
                    </td>
                    <td>
                        <div class="cell-title">{{ $employee->email ?? '—' }}</div>
                        <div class="cell-meta">{{ $employee->role ?? 'Employee' }}</div>
                    </td>
                    <td class="cell-meta">{{ $product->updated_at->format('Y-m-d') }}</td>
                    <td class="cell-meta">
                        @if($product->pending_status == 'pending_update')
                            <button class="btn-ghost" style="padding: 4px 10px; font-size: 12px;" onclick="openChangesModal({{ $product->id }})">View changes</button>
                        @elseif($product->pending_status == 'pending_creation')
                            New product request
                        @else
                            Delete request
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons" style="display: flex; gap: 8px;">
                            <form action="{{ route('admin.approvals.approve', $product) }}" method="POST">
                                @csrf
                                <button class="btn-icon approve"><i class="iconoir-check"></i></button>
                            </form>
                            <form action="{{ route('admin.approvals.reject', $product) }}" method="POST">
                                @csrf
                                <button class="btn-icon reject"><i class="iconoir-xmark"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">No pending approvals.</td>
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

{{-- View Changes Modal --}}
<div class="modal-overlay" id="changesModal">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h2 class="modal-title" id="modalProductTitle">Review changes</h2>
            <button class="modal-close" onclick="closeModal('changesModal')"><i class="iconoir-cancel"></i></button>
        </div>
        
        <div class="diff-grid" id="diffContent">
            {{-- Filled by JavaScript --}}
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-ghost" onclick="closeModal('changesModal')">Close</button>
            <form id="modalRejectForm" method="POST">
                @csrf
                <button type="submit" class="btn btn-ghost" style="color: var(--accent-terracotta);">Reject</button>
            </form>
            <form id="modalApproveForm" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Approve changes</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openChangesModal(productId) {
        fetch(`/admin/approvals/${productId}`)
            .then(response => response.json())
            .then(data => {
                const product = data.product;
                const pending = data.pending_data;
                const original = data.original_data;

                document.getElementById('modalProductTitle').innerText = `Review changes – ${product.name}`;
                
                let diffHtml = `
                    <div class="diff-column">
                        <h4>Current details</h4>
                `;
                for (let key in original) {
                    if (key === 'images' || key === 'id' || key === 'created_at' || key === 'updated_at') continue;
                    diffHtml += `
                        <div class="diff-item">
                            <div class="diff-label">${key.replace(/_/g, ' ')}</div>
                            <div class="diff-value">${original[key] ?? '—'}</div>
                        </div>
                    `;
                }
                diffHtml += `</div><div class="diff-column"><h4>Proposed changes</h4>`;
                for (let key in pending) {
                    if (key === 'images' || key === 'id') continue;
                    const changed = original[key] != pending[key];
                    diffHtml += `
                        <div class="diff-item">
                            <div class="diff-label">${key.replace(/_/g, ' ')}</div>
                            <div class="diff-value ${changed ? 'changed' : ''}">${pending[key] ?? '—'}</div>
                        </div>
                    `;
                }
                diffHtml += `</div>`;
                document.getElementById('diffContent').innerHTML = diffHtml;

                document.getElementById('modalApproveForm').action = `/admin/approvals/${productId}/approve`;
                document.getElementById('modalRejectForm').action = `/admin/approvals/${productId}/reject`;

                openModal('changesModal');
            });
    }
</script>
@endpush