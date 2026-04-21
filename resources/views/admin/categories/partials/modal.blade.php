<div class="modal-overlay" id="categoryModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('categoryModal')"><i class="iconoir-xmark"></i></button>
        <h2>Add category</h2>
        <p style="margin-bottom: 32px;">Create or edit a taxonomy group.</p>

        <form id="categoryForm" method="POST" onsubmit="event.preventDefault(); submitCategoryForm(this);">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <div class="form-group">
                <label>Category name *</label>
                <input type="text" name="name" placeholder="e.g. Ceramics" required>
            </div>

            <div class="form-group">
                <label>URL Slug (optional)</label>
                <input type="text" name="slug" placeholder="e.g. ceramics (auto-generated if empty)">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('categoryModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save category</button>
            </div>
        </form>
    </div>
</div>

<script>
    function submitCategoryForm(form) {
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