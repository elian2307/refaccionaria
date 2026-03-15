<div id="detailsModal" class="modal">
    <div class="modal-content">
        <h2>User Details</h2>
        <div class="modal-grid">
            <p><strong>Name:</strong> Orlando</p>
            <p><strong>Email:</strong> orlando@example.com</p>
            <p><strong>Level:</strong> <span class="sec">Admin</span></p>
            <p><strong>Fiscal ID:</strong> MOVO12344444</p>
            <p><strong>Phone number:</strong> 123456789</p>
            <p><strong>Reputation:</strong> <span class="suc">4.5</span></p>
            <p><strong>Premium:</strong> <span class="suc">Activated</span></p>
            <p><strong>Joined at:</strong> 2026-03-12</p>
        </div>
        <button class="btn" onclick="closeModal('detailsModal')">Close</button>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <h2>Edit User</h2>
        <form class="edit-user-form">
            <div class="form-group">
                <label>Name</label>
                <input type="text" value="Orlando" class="edit-input">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="orlando@example.com" class="edit-input">
            </div>

            <div class="form-group">
                <label>Level</label>
                <select class="edit-input eis">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="seller">Seller</option>
                </select>
            </div>
            <div class="form-group">
                <label>Fiscal ID</label>
                <input type="text" value="MOVO12344444" class="edit-input">
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" value="123456789" class="edit-input">
            </div>
            <div class="form-group">
                <label>Reputation (0-5)</label>
                <input type="number" value="4.5" step="0.1" min="0" max="5" class="edit-input">
            </div>

            <div class="form-group-checkbox">
                <label class="custom-checkbox">
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                    Premium Account
                </label>

            </div>
            <div class="form-group">
                <label>Joined at</label>
                <input type="date" value="2026-03-12" class="edit-input">
            </div>

            <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Save Changes</button>
        </form>
        <button class="btn dan" onclick="closeModal('editModal')">Delete User</button>
        <button class="btn" onclick="closeModal('editModal')">Close</button>
    </div>
</div>