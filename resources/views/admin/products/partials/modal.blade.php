<div class="modal-overlay" id="productModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('productModal')"><i class="iconoir-xmark"></i></button>
        <h2>Add new product</h2>
        <p style="margin-bottom: 32px;">Enter details for the new catalog item.</p>

        <form id="productForm" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); submitProductForm(this);">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <div class="form-group">
                <label>Product name</label>
                <input type="text" name="name" placeholder="e.g. Stoneware mug" required>
            </div>

            <div class="form-group">
                <label>Slug (optional, auto-generated)</label>
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
                    <label>Status</label>
                    <select name="is_active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price (USD)</label>
                    <input type="number" name="price" placeholder="0.00" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Stock quantity</label>
                    <input type="number" name="stock_quantity" placeholder="0" required>
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

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('productModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save product</button>
            </div>
        </form>
    </div>
</div>

<script>
    function submitProductForm(form) {
        const formData = new FormData(form);
        const action = form.action;
        const method = form.querySelector('input[name="_method"]').value;

        fetch(action, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }
</script>