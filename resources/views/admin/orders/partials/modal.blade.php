<div class="modal-overlay" id="orderModal">
    <div class="modal-content" style="max-width: 800px; border-radius: var(--radius-lg); padding: 64px;">
        <button class="modal-close" onclick="closeModal('orderModal')" style="top: 40px; right: 40px;"><i class="iconoir-xmark"></i></button>

        <div style="display: flex; align-items: baseline; gap: 16px; margin-bottom: 8px;">
            <h2 style="margin: 0; font-size: 32px;" id="modal-order-number">#ORD-1234</h2>
            <span class="badge" id="modal-status-badge" style="text-transform: uppercase; letter-spacing: 0.05em;">Pending</span>
        </div>
        <p style="margin-bottom: 48px; color: var(--text-secondary);" id="modal-order-date">Placed on ...</p>

        <div class="order-meta-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-bottom: 48px; padding-bottom: 48px; border-bottom: 1px solid var(--border-subtle);">
            <div class="meta-block">
                <h3 style="margin-bottom: 16px;">Customer</h3>
                <p id="modal-customer-name" style="margin-bottom: 4px; color: var(--text-primary);">—</p>
                <p id="modal-customer-email" style="margin-bottom: 4px;">—</p>
                <p id="modal-customer-phone" style="margin-bottom: 0;">—</p>
            </div>
            <div class="meta-block">
                <h3 style="margin-bottom: 16px;">Shipping address</h3>
                <div id="modal-shipping-address" style="line-height: 1.7;">—</div>
            </div>
        </div>

        <h3 style="margin-bottom: 24px;">Items</h3>
        <div style="border: 1px solid var(--border-subtle); border-radius: var(--radius-md); overflow: hidden; margin-bottom: 48px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-subtle);">
                        <th style="text-align: left; padding: 16px 24px;">Item</th>
                        <th style="text-align: left; padding: 16px 24px;">Qty</th>
                        <th style="text-align: right; padding: 16px 24px;">Total</th>
                    </tr>
                </thead>
                <tbody id="modal-items-body">
                    {{-- Filled by JavaScript --}}
                </tbody>
            </table>
            <div style="padding: 24px; background-color: var(--bg-base); border-top: 1px solid var(--border-subtle);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <span style="color: var(--text-secondary);">Subtotal <span id="modal-total-items"></span></span>
                    <span id="modal-subtotal" style="color: var(--text-primary); font-weight: 500;">$0.00</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <span style="color: var(--text-secondary);">Shipping</span>
                    <span style="color: var(--accent-sage); font-weight: 500;">Free</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border-subtle);">
                    <span style="font-weight: 500; color: var(--text-primary);">Total</span>
                    <span id="modal-total" style="font-weight: 500; font-size: 18px; color: var(--text-primary);">$0.00</span>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-bottom: 48px;">
            <div class="meta-block">
                <h3 style="margin-bottom: 16px;">Payment method</h3>
                <p id="modal-payment-method" style="color: var(--text-primary);">—</p>
            </div>
        </div>

        {{-- Status update --}}
        <div style="padding-top: 48px; border-top: 1px solid var(--border-subtle);">
            <form id="status-update-form" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group" style="margin-bottom: 24px;">
                    <label style="margin-bottom: 12px; display: block;">Update order status</label>
                    <div style="display: flex; gap: 16px;">
                        <select name="status" id="status-select" class="input-styled" style="flex-grow: 1; padding: 12px 16px; border: 1px solid var(--border-subtle); border-radius: var(--radius-sm);">
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
            <form id="modal-delete-form" method="POST" onsubmit="return confirm('Permanently delete this order? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-ghost" style="width: 100%; color: var(--accent-clay); border-color: var(--accent-clay); margin-top: 8px;">
                    <i class="iconoir-trash" style="margin-right: 8px;"></i>Delete order
                </button>
            </form>
            @endif
        </div>
    </div>
</div>