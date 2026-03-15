<div id="detailsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('detailsModal')">&times;</span>
        <h2>User Details</h2>
        <div class="modal-grid">
            <p><strong>Email:</strong> orlando@example.com</p>
            <p><strong>Fiscal ID:</strong> MOVO12344444</p>
            <p><strong>Phone:</strong> 123456789</p>
            <p><strong>Premium:</strong> <span class="suc">Activated</span></p>
        </div>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h2>Edit User</h2>
        <form>
            <input type="text" value="Orlando" class="edit-input">
            <input type="email" value="orlando@example.com" class="edit-input">
            <button type="submit" class="btn-primary">Save Changes</button>
        </form>
    </div>
</div>