<div class="modal-overlay" id="orderModal">
    <div class="modal-content" style="max-width: 800px;">
        <button class="modal-close" onclick="closeModal('orderModal')"><i class="iconoir-xmark"></i></button>

        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <h2 style="margin: 0;" id="modal-order-number">#ORD-1234</h2>
            <span class="badge badge-pending" id="modal-status-badge">Pending</span>
        </div>
        <p style="margin-bottom: 40px;" id="modal-order-date">Placed on ...</p>

        <div class="order-meta-grid">
            <div class="meta-block">
                <p><strong>Customer</strong></p>
                <p id="modal-customer-name">—</p>
                <p id="modal-customer-email">—</p>
                <p id="modal-customer-phone">—</p>
            </div>
            <div class="meta-block">
                <p><strong>Shipping address</strong></p>
                <div id="modal-shipping-address">—</div>
            </div>
        </div>

        <h3 style="margin-bottom: 16px;">Items</h3>
        <div style="border: 1px solid var(--border-subtle); border-radius: 4px; margin-bottom: 32px;">
            <table style="margin-bottom: 0;">
                <thead style="border-bottom: 1px solid var(--border-subtle);">
                    <tr>
                        <th style="padding: 12px 16px;">Item</th>
                        <th style="padding: 12px 16px;">Qty</th>
                        <th style="padding: 12px 16px;">Total</th>
                    </tr>
                </thead>
                <tbody id="modal-items-body">
                    {{-- Filled by JavaScript --}}
                </tbody>
            </table>
            <div style="padding: 16px; background-color: var(--bg-base); border-top: 1px solid var(--border-subtle);">
                <div style="display: flex; justify-content: space-between; font-weight: 400;">
                    <span>Subtotal <span id="modal-total-items"></span></span>
                    <span id="modal-subtotal">$0.00</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-weight: 400; margin-top: 8px;">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-weight: 500; margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border-subtle);">
                    <span>Total</span>
                    <span id="modal-total">$0.00</span>
                </div>
            </div>
        </div>

        <div class="meta-block" style="margin-bottom: 24px;">
            <p><strong>Payment method</strong></p>
            <p id="modal-payment-method">—</p>
        </div>

        {{-- Status update (both roles) --}}
        <form id="status-update-form" method="POST" style="margin-top: 32px;">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Update order status</label>
                <div style="display: flex; gap: 16px;">
                    <select name="status" id="status-select" style="width: auto; min-width: 200px;">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Update status</button>
                </div>
            </div>
        </form>

        {{-- Admin-only delete --}}
        @if(auth()->user()->role === 'admin')
        <form id="modal-delete-form" method="POST" style="margin-top: 16px;" onsubmit="return confirm('Permanently delete this order? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-ghost" style="color: var(--accent-clay); border-color: var(--accent-clay);">
                <i class="iconoir-trash" style="margin-right: 6px;"></i>Delete order
            </button>
        </form>
        @endif
    </div>
</div>