<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3><i class="fa-solid fa-star"></i> Total Reviews</h3>
        <p class="value">{{ $reviews->count() }}</p>
    </div>
    <div class="card">
        <h3><i class="fa-regular fa-face-smile"></i> Good Reviews</h3>
        <p class="value">{{ $reviews->where('calificacion', '>=', 4)->count() }}</p>
    </div>
    <div class="card">
        <h3><i class="fa-regular fa-face-frown"></i> Bad Reviews</h3>
        <p class="value">{{ $reviews->where('calificacion', '<', 4)->count() }}</p>
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
    @foreach ($reviews as $review)
        <div class="review-card">
            <div class="review-header">
                <h3 class="@if($review->calificacion > 3) good @elseif($review->calificacion == 3) neutral @else bad @endif"><i class="fa-solid fa-comment-dots"></i> Review #{{ $review->id }}</h3>
                <p>Rating:<span class="@if($review->calificacion > 3) good @elseif($review->calificacion == 3) neutral @else bad @endif"> {{ $review->calificacion }} <span class="sec">★</span></span></p>
            </div>
            <div class="review-body">
                <p>From: <b>{{ $review->autor->nombre ?? 'Unknown' }}</b></p>
                <p>To: <b>{{ $review->receptor->nombre ?? 'Unknown' }}</b></p>
                <p>Order: <b>{{ $review->pedido->numero_rastreo ?? $review->pedido_id }}</b></p>
                <p>Date: {{ $review->created_at }}</p>
                <p class="yousaidsmt">{{ $review->comentario }}</p>
            </div>

            @if(auth()->user()->rol === 'admin')
                <div class="review-actions">
                    <button class="btn dan" onclick="openModal('detailsModalYS{{ $review->id }}')">Delete</button>
                </div>
            @endif
        </div>

        @if(auth()->user()->rol === 'admin')
            <div id="detailsModalYS{{ $review->id }}" class="modal">
                <div class="modal-content">
                    <h2>Are you sure?</h2>
                    <button class="btn" onclick="closeModal('detailsModalYS{{ $review->id }}')">Cancel</button>
                    <button class="btn dan" onclick="deleteReview({{ $review->id }})">Yes</button>
                    <button class="btn" onclick="closeModal('detailsModalYS{{ $review->id }}')">Close</button>
                </div>
            </div>
        @endif
    @endforeach

</section>