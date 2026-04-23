@extends('layouts.admin')

@section('title', 'Coupons — Aura. Admin')
@section('page-title', 'Coupons')

@section('content')
<div class="page">
    <div class="section-header">
        <div>
            <h1>Coupon Management</h1>
            <p>Create and manage discount codes for your store.</p>
        </div>
        <div>
            <button class="btn btn-primary" onclick="openModal('create-modal')">Create new coupon</button>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Type & Value</th>
                    <th>Min. Order</th>
                    <th>Usage</th>
                    <th>Expires</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td style="font-weight: 500;">{{ $coupon->code }}</td>
                    <td>
                        @if($coupon->type === 'percentage')
                            {{ $coupon->value }}% off
                        @else
                            ${{ number_format($coupon->value, 2) }} off
                        @endif
                    </td>
                    <td>
                        {{ $coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) : '—' }}
                    </td>
                    <td>
                        {{ $coupon->uses }} / {{ $coupon->max_uses ?? '∞' }}
                    </td>
                    <td>
                        {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never' }}
                    </td>
                    <td>
                        @if($coupon->is_active && (!$coupon->expires_at || !$coupon->expires_at->isPast()) && ($coupon->max_uses === null || $coupon->uses < $coupon->max_uses))
                            <span class="badge badge-active">Active</span>
                        @else
                            <span class="badge badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn-icon" onclick="openEditModal({{ $coupon->toJson() }})" title="Edit">
                                <i class="iconoir-edit-pencil"></i>
                            </button>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete">
                                    <i class="iconoir-trash" style="color: var(--accent-terracotta);"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">No coupons created yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Modal --}}
<div id="create-modal" class="modal-overlay" onclick="if(event.target === this) closeModal('create-modal')">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('create-modal')"><i class="iconoir-cancel"></i></button>
        <h2>Create Coupon</h2>
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="code">Coupon Code</label>
                <input type="text" id="code" name="code" required placeholder="e.g. SUMMER20" style="text-transform: uppercase;">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="type">Discount Type</label>
                    <select id="type" name="type" required>
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed Amount ($)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="value">Discount Value</label>
                    <input type="number" id="value" name="value" required min="0.01" step="0.01" placeholder="e.g. 10">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="min_order_amount">Min. Order Amount (Optional)</label>
                    <input type="number" id="min_order_amount" name="min_order_amount" min="0" step="0.01" placeholder="e.g. 50">
                </div>
                <div class="form-group">
                    <label for="max_uses">Max Uses (Optional)</label>
                    <input type="number" id="max_uses" name="max_uses" min="1" placeholder="e.g. 100">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="expires_at">Expiration Date (Optional)</label>
                    <input type="date" id="expires_at" name="expires_at">
                </div>
                <div class="form-group" style="display: flex; align-items: flex-end; padding-bottom: 12px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" checked style="width: auto;">
                        <span>Coupon is active</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('create-modal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Coupon</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="modal-overlay" onclick="if(event.target === this) closeModal('edit-modal')">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('edit-modal')"><i class="iconoir-cancel"></i></button>
        <h2>Edit Coupon: <span id="edit-code-display"></span></h2>
        <form id="edit-form" method="POST">
            @csrf @method('PATCH')
            <div class="form-row">
                <div class="form-group">
                    <label for="edit-type">Discount Type</label>
                    <select id="edit-type" name="type" required>
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed Amount ($)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-value">Discount Value</label>
                    <input type="number" id="edit-value" name="value" required min="0.01" step="0.01">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="edit-min_order_amount">Min. Order Amount (Optional)</label>
                    <input type="number" id="edit-min_order_amount" name="min_order_amount" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label for="edit-max_uses">Max Uses (Optional)</label>
                    <input type="number" id="edit-max_uses" name="max_uses" min="1">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="edit-expires_at">Expiration Date (Optional)</label>
                    <input type="date" id="edit-expires_at" name="expires_at">
                </div>
                <div class="form-group" style="display: flex; align-items: flex-end; padding-bottom: 12px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" id="edit-is_active" name="is_active" value="1" style="width: auto;">
                        <span>Coupon is active</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('edit-modal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function openEditModal(coupon) {
        document.getElementById('edit-code-display').textContent = coupon.code;
        document.getElementById('edit-form').action = `/admin/coupons/${coupon.id}`;
        document.getElementById('edit-type').value = coupon.type;
        document.getElementById('edit-value').value = coupon.value;
        document.getElementById('edit-min_order_amount').value = coupon.min_order_amount || '';
        document.getElementById('edit-max_uses').value = coupon.max_uses || '';
        
        if (coupon.expires_at) {
            document.getElementById('edit-expires_at').value = coupon.expires_at.split('T')[0];
        } else {
            document.getElementById('edit-expires_at').value = '';
        }
        
        document.getElementById('edit-is_active').checked = !!coupon.is_active;
        
        openModal('edit-modal');
    }
</script>
@endpush
