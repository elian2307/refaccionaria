<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3>Active Auctions</h3>
        <p class="value">622</p>
    </div>
    <div class="card">
        <h3>Completed Auctions</h3>
        <p class="value">1353</p>
    </div>
    <div class="card">
        <h3>Cancelled Auctions</h3>
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
            <option value="1">Open</option>
            <option value="2">New</option>
            <option value="0">Damaged</option>
        </select>
    </div>
    <div class="sort-container">
        <h4>Priority:</h4>
        <select class="sort-selects" name="sort-level" id="sort-type">
            <option value="all">All</option>
            <option value="0">Low</option>
            <option value="1">Regular</option>
            <option value="2">High</option>
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


<section class="auction-container">

    <div class="auction-card">
        <div class="autismo">
            <div class="auctionleft">
                <div class="auction-header">
                    <h3>Honda Civic 2010</h3>
                </div>
                <div class="auction-body">
                    <p>Piece: <b>Motor</b></p>
                    <p>Offer price: <b>$500.00</b></p>
                    <p>Expiration date: 2026-03-12</p>
                    <p>Status: <span class="suc"><b>Open</b></span></p>
                </div>
            </div>
            <div class="auctionright">
                <img src="{{ asset('/joee/img/default.jpg') }}" alt="">
            </div>
        </div>


        <div class="auction-actions">
            <button class="btn" onclick="openModal('detailsModalAuct')">Details</button>
        </div>
    </div>

</section>