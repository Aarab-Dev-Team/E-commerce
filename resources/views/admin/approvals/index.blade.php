@extends('layouts.admin')

@section('title', 'Pending Approvals — Aura. Admin')
@section('page-title', 'Approvals')

@push('styles')
<style>
    .tabs {
        border-bottom: none !important;
        gap: 12px !important;
        margin-bottom: 32px !important;
    }
    .tab {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-subtle) !important;
        border-radius: 4px !important;
        padding: 8px 16px !important;
        margin-bottom: 0 !important;
        font-size: 13px;
        transition: all 0.2s ease;
    }
    .tab:hover {
        border-color: var(--text-secondary) !important;
        color: var(--text-primary) !important;
    }
    .tab.active {
        border-color: var(--text-primary) !important;
        color: var(--text-primary) !important;
        background-color: var(--bg-base);
    }
</style>
@endpush

@section('content')
<div class="page">
    <div class="section-header" style="align-items: flex-start;">
        <div>
            <h1 style="display: flex; align-items: center; gap: 12px;">
                Pending approvals
                @if($pendingCount > 0)
                    <span class="count-badge">{{ $pendingCount }}</span>
                @endif
            </h1>
            @if(auth()->user()->role === 'employee')
                <p>All pending product requests — contact an admin to approve or reject changes.</p>
            @else
                <p>Review and approve changes submitted by employees.</p>
            @endif
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tabs">
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
                    <th>Date</th>
                    <th>Changes</th>
                    @if(auth()->user()->role === 'admin')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="product-cell" style="display: flex; align-items: center; gap: 12px;">
                            <div class="avatar-img" style="width: 36px; height: 36px; border-radius: 4px; background: var(--bg-base); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                                @if($product->images && isset($product->images[0]))
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                                @else
                                    <i class="iconoir-image" style="color: var(--text-muted); font-size: 14px;"></i>
                                @endif
                            </div>
                            <div>
                                <span class="cell-title">{{ $product->name ?? 'New Product' }}</span>
                                <div class="cell-meta">{{ $product->category->name ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $type = str_replace('pending_', '', $product->pending_status);
                            $typeClass = match($type) {
                                'creation' => 'badge-creation',
                                'update'   => 'badge-update',
                                'deletion' => 'badge-deletion',
                                default    => 'badge-inactive',
                            };
                        @endphp
                        <span class="badge {{ $typeClass }}">{{ ucfirst($type) }}</span>
                    </td>
                    <td class="cell-meta">{{ $product->updated_at->format('M d, Y') }}</td>
                    <td class="cell-meta">
                        @if($product->pending_status == 'pending_update')
                            @if(auth()->user()->role === 'admin')
                                <button class="btn-ghost" style="padding: 4px 10px; font-size: 12px;" onclick="openChangesModal({{ $product->id }})">View diff</button>
                            @else
                                <span style="font-size: 12px; color: var(--text-muted);">Update pending</span>
                            @endif
                        @elseif($product->pending_status == 'pending_creation')
                            <span style="font-size: 12px; color: var(--text-muted);">New product</span>
                        @else
                            <span style="font-size: 12px; color: var(--text-muted);">Deletion request</span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td>
                        <div class="action-buttons" style="display: flex; gap: 8px;">
                            <form action="{{ route('admin.approvals.approve', $product) }}" method="POST">
                                @csrf
                                <button class="btn-icon approve" title="Approve"><i class="iconoir-check"></i></button>
                            </form>
                            <form action="{{ route('admin.approvals.reject', $product) }}" method="POST">
                                @csrf
                                <button class="btn-icon reject" title="Reject"><i class="iconoir-xmark"></i></button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" style="text-align: center; padding: 60px; color: var(--text-muted);">
                        <i class="iconoir-check-circle" style="font-size: 32px; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
                        No pending approvals.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $products->links('pagination.admin') }}
    </div>
</div>

{{-- View Changes Modal (admin only) --}}
@if(auth()->user()->role === 'admin')
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
                <button type="submit" class="btn btn-ghost" style="color: var(--accent-clay);">Reject</button>
            </form>
            <form id="modalApproveForm" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Approve changes</button>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
@if(auth()->user()->role === 'admin')
<script>
    function openChangesModal(productId) {
        fetch(`/admin/approvals/${productId}`)
            .then(response => response.json())
            .then(data => {
                const product  = data.product;
                const pending  = data.pending_data  || {};
                const original = data.original_data || {};

                document.getElementById('modalProductTitle').innerText = `Review changes — ${product.name}`;

                let diffHtml = `<div class="diff-column"><h4>Current details</h4>`;
                for (let key in original) {
                    if (['images','id','created_at','updated_at','pending_status','pending_data','original_data'].includes(key)) continue;
                    diffHtml += `
                        <div class="diff-item">
                            <div class="diff-label">${key.replace(/_/g,' ')}</div>
                            <div class="diff-value">${original[key] ?? '—'}</div>
                        </div>`;
                }
                diffHtml += `</div><div class="diff-column"><h4>Proposed changes</h4>`;
                for (let key in pending) {
                    if (['images','id'].includes(key)) continue;
                    const changed = String(original[key]) !== String(pending[key]);
                    diffHtml += `
                        <div class="diff-item">
                            <div class="diff-label">${key.replace(/_/g,' ')}</div>
                            <div class="diff-value ${changed ? 'changed' : ''}">${pending[key] ?? '—'}</div>
                        </div>`;
                }
                diffHtml += `</div>`;
                document.getElementById('diffContent').innerHTML = diffHtml;

                document.getElementById('modalApproveForm').action = `/admin/approvals/${productId}/approve`;
                document.getElementById('modalRejectForm').action  = `/admin/approvals/${productId}/reject`;

                openModal('changesModal');
            });
    }
</script>
@endif
@endpush