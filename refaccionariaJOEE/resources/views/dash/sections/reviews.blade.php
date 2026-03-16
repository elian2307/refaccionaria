<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3>Total Reviews</h3>
        <p class="value">3631</p>
    </div>
    <div class="card">
        <h3>Good Reviews</h3>
        <p class="value">1456</p>
    </div>
    <div class="card">
        <h3>Bad Reviews</h3>
        <p class="value">446</p>
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
    <div class="sort-container2">
        <h4>Search</h4>
        <div class="search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="" id="" placeholder="Search something">
        </div>
    </div>
</div>

<h3>Results</h3>

<section class="review-container">
    
    <div class="review-card">
        <div class="review-header">
            <h3>Review #(ID)</h3>
            <p>Rating:<span class="sec"> 6 ★</span></p>
        </div>
        <div class="review-body">
            <p>From: <b>Orlando</b></p>
            <p>To: <b>Maria</b></p>
            <p>Date: 2026-03-12</p>
            <p>Order: <span style="cursor:pointer;" class="suc" onclick="openModal('detailsModalOrder')">See</span></p>
            <p class="yousaidsmt">Buen producto, aunque la entrega tardó un poco más de lo esperado.</p>
        </div>
        <div class="review-actions">
            <button class="btn dan" onclick="openModal('detailsModalYS')">Delete</button>
        </div>
    </div>

</section>


