<div class="modal-overlay" id="productModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('productModal')"><i class="iconoir-xmark"></i></button>
        <h2>Add new product</h2>
        <p style="margin-bottom: 32px;">
            @if(auth()->user()->role === 'admin')
                Enter details for the new catalog item.
            @else
                Submit a new product for admin approval.
            @endif
        </p>

        <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <div class="form-group">
                <label>Product name</label>
                <input type="text" name="name" placeholder="e.g. Stoneware mug" required>
            </div>

            <div class="form-group">
                <label>Slug <span style="font-size: 11px; color: var(--text-muted);">(optional, auto-generated)</span></label>
                <input type="text" name="slug" placeholder="stoneware-mug">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" required>
                        <option value="">Select category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Visibility</label>
                    @if(auth()->user()->role === 'admin')
                        <select name="is_active">
                            <option value="1">Active (visible to customers)</option>
                            <option value="0">Inactive (hidden)</option>
                        </select>
                    @else
                        {{-- Employees: read-only, always starts as inactive pending approval --}}
                        <div style="padding: 10px 0; font-size: 14px; color: var(--text-muted);">
                            <i class="iconoir-clock" style="font-size: 14px;"></i>
                            Will be inactive until approved
                        </div>
                        <input type="hidden" name="is_active" value="0">
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price (USD)</label>
                    <input type="number" name="price" placeholder="0.00" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label>Stock quantity</label>
                    <input type="number" name="stock_quantity" placeholder="0" min="0" required>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Brief editorial description of the item..." required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Material</label>
                    <input type="text" name="material" placeholder="e.g. Stoneware">
                </div>
                <div class="form-group">
                    <label>Origin</label>
                    <input type="text" name="origin" placeholder="e.g. Kyoto">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" name="color" placeholder="e.g. Warm Sand">
                </div>
                <div class="form-group">
                    <label>Images</label>
                    <input type="file" name="images[]" multiple accept="image/*" style="border: none; padding-left: 0;">
                </div>
            </div>

            {{-- Employee notice --}}
            @if(auth()->user()->role === 'employee')
            <div style="background: var(--bg-base); border: 1px solid var(--border-subtle); border-radius: 4px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: var(--text-secondary);">
                <i class="iconoir-info-circle" style="font-size: 14px; vertical-align: middle;"></i>
                This product will be submitted for admin review before it becomes visible to customers.
            </div>
            @endif

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('productModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    @if(auth()->user()->role === 'admin')
                        Save product
                    @else
                        Submit for approval
                    @endif
                </button>
            </div>
        </form>
    </div>
</div>