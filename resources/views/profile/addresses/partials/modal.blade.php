<div class="modal-overlay" id="addressModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add new address</h2>
            <i  class="iconoir-xmark-square close-modal" style="font-size: 32px;"></i>
        </div>


        <form id="addressForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="method-input" value="POST">
            <div class="modal-body">
                <div class="form-grid">
                    {{-- Full Name --}}
                    <div class="form-group full-width">
                        <label>Full Name *</label>
                        <input type="text" name="full_name" placeholder="First and Last Name" required>
                    </div>
                    {{-- Phone --}}
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" placeholder="+1 234 567 890">
                    </div>
                    {{-- Country --}}
                    <div class="form-group">
                        <label>Country *</label>
                        <select name="country" required>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="UK">United Kingdom</option>
                            <option value="AU">Australia</option>
                            <option value="JP">Japan</option>
                            <option value="DK">Denmark</option>
                        </select>
                    </div>
                    {{-- Address Line 1 --}}
                    <div class="form-group full-width">
                        <label>Address Line 1 *</label>
                        <input type="text" name="address_line_1" placeholder="Street address" required>
                    </div>
                    {{-- Address Line 2 --}}
                    <div class="form-group full-width">
                        <label>Address Line 2</label>
                        <input type="text" name="address_line_2" placeholder="Apartment, suite, etc.">
                    </div>
                    {{-- City --}}
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="city" required>
                    </div>
                    {{-- State --}}
                    <div class="form-group">
                        <label>State / Province *</label>
                        <input type="text" name="state" required>
                    </div>
                    {{-- Postal Code --}}
                    <div class="form-group">
                        <label>Postal Code *</label>
                        <input type="text" name="postal_code" required>
                    </div>
                    {{-- Address Type --}}
                    <div class="form-group full-width">
                        <label>Address Type *</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="type" value="shipping" checked required> Shipping
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="type" value="billing"> Billing
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="type" value="both"> Both
                            </label>
                        </div>
                    </div>
                    {{-- Default --}}
                    <div class="form-group full-width">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_default" value="1">
                            Set as default address
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" id="cancelModalBtn">Cancel</button>
                <button type="submit" class="btn-filled">Save address</button>
            </div>
        </form>
    </div>
</div>