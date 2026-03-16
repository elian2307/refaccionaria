<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3>Active Orders</h3>
        <p class="value">7822</p>
    </div>
    <div class="card">
        <h3>Paid Orders</h3>
        <p class="value">453</p>
    </div>
    <div class="card">
        <h3>Cancelled Orders</h3>
        <p class="value">42</p>
    </div>
</section>

<h3>Sort by</h3>

<div class="filters">
    <div class="sort-container">
        <h4>Date:</h4>
        <select class="sort-selects" name="sort-time" id="sort-select">
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
        </select>
    </div>
    <div class="sort-container">
        <h4>Payment status:</h4>
        <select class="sort-selects" name="sort-level" id="sort-type">
            <option value="all">All</option>
            <option value="1">Pending</option>
            <option value="2">Done</option>
            <option value="0">Cancelled</option>
        </select>
    </div>
    <div class="sort-container">
        <h4>Shipping status:</h4>
        <select class="sort-selects" name="sort-level" id="sort-type">
            <option value="all">All</option>
            <option value="1">Pending</option>
            <option value="2">Done</option>
            <option value="0">Cancelled</option>
        </select>
    </div>
    <div class="sort-container2">
        <h4>Search</h4>
        <div class="search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="" id="" placeholder="Search something">
        </div>
    </div>
</div>

<h3>Results</h3>

<section class="order-container">
    
    <div class="order-card">
        <div class="order-header">
            <h3>Order 107553 (Numero de rastreo)</h3>
            <span class="sec">Payment pending</span>
        </div>
        <div class="order-body">
            <p>Offer price: <b>$500.00</b></p>
            <p>Order date: 2026-03-12</p>
        </div>
        <div class="order-actions">
            <button class="btn" onclick="openModal('detailsModalOrder')">Details</button>
        </div>
    </div>

</section>