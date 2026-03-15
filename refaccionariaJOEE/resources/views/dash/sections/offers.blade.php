<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3>Active Offers</h3>
        <p class="value">322</p>
    </div>
    <div class="card">
        <h3>Declined Offers</h3>
        <p class="value">1663</p>
    </div>
    <div class="card">
        <h3>Accepted Offers</h3>
        <p class="value">462</p>
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
        <h4>Status:</h4>
        <select class="sort-selects" name="sort-level" id="sort-type">
            <option value="all">All</option>
            <option value="1">Accepted</option>
            <option value="2">Pending</option>
            <option value="0">Declined</option>
        </select>
    </div>
    <div class="sort-container2">
        <h4>Search</h4>
        <div class="search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="" id="" placeholder="Search someone">
        </div>
    </div>
</div>

<h3>Results</h3>

<section class="offer-container">
    
    <div class="offer-card">
        <div class="offer-header">
            <h3>Auction 1</h3>
            <span class="sec">Pending</span>
        </div>
        <div class="offer-body">
            <p>Offer price: <b>$500.00</b></p>
            <p>Offer date: 2026-03-12</p>
        </div>
        <div class="offer-actions">
            <button class="btn" onclick="openModal('detailsModalOffer')">Details</button>
        </div>
    </div>

</section>


