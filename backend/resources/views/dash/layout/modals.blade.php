
<!-- USERS !-->
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
            <p><strong>Addresses:</strong> <span class="sec" onclick="openModal('addressesModal')" id="addresses">Show</span></p>
        </div>
        <button class="btn" onclick="closeModal('detailsModal')">Close</button>
    </div>
</div>

<div id="addressesModal" class="modal">
    <div class="modal-content">
        <h2>User Addresses</h2>
        <div class="modal-grid">
            <h3>Address 1</h3>
            <p><strong>Street:</strong> Calle ignacio zaragoza</p>
            <p><strong>Number:</strong> 123</p>
            <p><strong>Colony:</strong> Inventada</p>
            <p><strong>Municipality:</strong> Imaginario</p>
            <p><strong>State:</strong> Fantasma</p>
            <p><strong>Postal Code:</strong> 21240</p>  
        </div>
        <div class="modal-grid">
        </div>
        <button class="btn" onclick="closeModal('addressesModal')">Close</button>
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
        <button class="btn dan" onclick="openModal('detailsModalYS')">Delete User</button>
        <button class="btn" onclick="closeModal('editModal')">Close</button>
    </div>
</div>




<!-- OFFERS !-->
<div id="detailsModalOffer" class="modal">
    <div class="modal-content">
        <h2>Offer Details</h2>
        <div class="modal-grid">
            <p><strong>Auction ID:</strong> 1 <span class="sec" style="cursor:pointer;" id="seeAuction" onclick="openModal('detailsModalAuct')">(see more)</span></p>
            <p><strong>Supplier:</strong> Maria</p>
            <p><strong>Offer price:</strong> <span class="suc">500</span></p>
            <p><strong>Days delivery:</strong> 14</p>
            <p><strong>Usage:</strong> <span class="sec">New</span></p>
            <p><strong>Warranty months:</strong> 12</p>
            <p><strong>Status:</strong> <span class="pen">Pending</span></p>
            <p><strong>Offer date:</strong> 2026-03-12</p>
        </div>
        <button class="btn dan" onclick="openModal('detailsModalYS')">Delete Offer</button>
        <button class="btn" onclick="closeModal('detailsModalOffer')">Close</button>
    </div>
</div>

<!-- AUCTIONS !-->
 <div id="detailsModalAuct" class="modal">
    <div class="modal-content">
        <h2>Auction Details</h2>
        <div class="modal-grid">
            <p><strong>By user:</strong> Orlando</p>
            <p><strong>Vehicle brand:</strong> Honda</p>
            <p><strong>Vehicle model:</strong> Civic</p>
            <p><strong>Vehicle year:</strong> 2010</p>
            <p><strong>Repair piece:</strong> Engine</p>
            <p><strong>Description:</strong> Motor en buen estado, con poco uso, ideal para Honda Civic 2010.</p>
            <p><strong>Priority:</strong> <span class="suc">High</span></p>
            <p><strong>Status:</strong> <span class="suc">Open</span></p>
            <p><strong>Expiration date:</strong> 2026-03-12</p>
        </div>
        <button class="btn dan" onclick="openModal('detailsModalYS')">End Auction</button>
        <button class="btn dan" onclick="openModal('detailsModalYS')">Delete Auction</button>
        <button class="btn" onclick="closeModal('detailsModalAuct')">Close</button>
    </div>
</div>

<!-- ORDERS !-->
 <div id="detailsModalOrder" class="modal">
    <div class="modal-content">
        <h2>Order Details</h2>
        <div class="modal-grid">
            <p><strong>Auction ID:</strong> 1 <span class="sec" style="cursor:pointer;" id="seeAuction" onclick="openModal('detailsModalAuct')">(see more)</span></p>
            <p><strong>Offer ID:</strong> 1 <span class="sec" style="cursor:pointer;" id="seeOffer" onclick="openModal('detailsModalOffer')">(see more)</span></p>
            <p><strong>Order by:</strong> Orlando</p>
            <p><strong>Total payment:</strong> <span class="suc">$500.00</span></p>
            <p><strong>Comissions:</strong> <span class="suc">$50.00</span></p>
            <p><strong>Payment status:</strong> <span class="pen">Pending</span></p>
            <p><strong>Shipping status:</strong> <span class="pen">Pending</span></p>
            <p><strong>Tracking number:</strong> 107553</p>
            <p><strong>Order date:</strong> 2026-03-12</p>
        </div>
        <button class="btn dan" onclick="openModal('detailsModalYS')">Cancel Offer</button>
        <button class="btn dan" onclick="openModal('detailsModalYS')">Delete Offer</button>
        <button class="btn" onclick="closeModal('detailsModalOrder')">Close</button>
    </div>
</div>


<!-- YOUSURE !-->
 <div id="detailsModalYS" class="modal">
    <div class="modal-content">
        <h2>Are you sure?</h2>
        <button class="btn" onclick="closeModal('detailsModalYS')">Cancel</button>
        <button class="btn dan" onclick="closeModal('detailsModalYS')">Yes</button>
        <button class="btn" onclick="closeModal('detailsModalYS')">Close</button>
    </div>
</div>