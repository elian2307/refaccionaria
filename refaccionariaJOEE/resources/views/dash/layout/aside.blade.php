<aside>
    <div class="logo">
        <img src="{{ asset('/joee/img/iso.png') }}" alt="">
        <span>JOEE MECHANICS</span>
    </div>
    <nav>
        <ul>
            <li class="icanchangejiji selectedf" data-section="dashboard" data-title="Dashboard"
                data-desc="Get a quick overview of your business performance and daily activities.">
                <i class="fa-solid fa-clipboard-list"></i><span>Dashboard</span>
            </li>

            <li class="icanchangejiji" data-section="statics" data-title="Statics"
                data-desc="Analyze key performance indicators and growth trends inside.">
                <i class="fa-solid fa-chart-line"></i><span>Statics</span>
            </li>

            @if(auth()->user()->rol === 'admin')
                <li class="icanchangejiji" data-section="users" data-title="Users"
                    data-desc="Manage registered users, levels, and administrative access.">
                    <i class="fa-solid fa-users"></i><span>Users</span>
                </li>
            @endif

            @if(in_array(auth()->user()->rol, ['admin', 'vendedor', 'comprador']))
                <li class="icanchangejiji" data-section="orders" data-title="Orders"
                    data-desc="Track, update, and process incoming orders.">
                    <i class="fa-solid fa-box-open"></i><span>Orders</span>
                </li>
            @endif

            @if(in_array(auth()->user()->rol, ['admin', 'comprador']))
                <li class="icanchangejiji" data-section="offers" data-title="Offers"
                    data-desc="Manage active offers that users propose to active auctions.">
                    <i class="fa-solid fa-tags"></i><span>Offers</span>
                </li>
            @endif

            @if(in_array(auth()->user()->rol, ['admin', 'vendedor']))
                <li class="icanchangejiji" data-section="auctions" data-title="Auctions"
                    data-desc="Manage every auction in timeline.">
                    <i class="fa-solid fa-gavel"></i><span>Auctions</span>
                </li>
            @endif

            @if(in_array(auth()->user()->rol, ['admin', 'vendedor', 'comprador']))
                <li class="icanchangejiji" data-section="reviews" data-title="Reviews"
                    data-desc="Moderation center for feedback and product ratings.">
                    <i class="fa-solid fa-bullhorn"></i><span>Reviews</span>
                </li>
            @endif

            @if(auth()->user()->rol === 'admin')
                <li class="icanchangejiji" data-section="settings" data-title="Settings"
                    data-desc="Configure system preferences, profile details, and application settings.">
                    <i class="fa-solid fa-gear"></i><span>Settings</span>
                </li>
            @endif
        </ul>
        <ul>
            <li id="gohome"><i class="fa-solid fa-house"></i><span>Home</span></li>
            
            <li class="dan">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="all: unset; display: flex; align-items: center; gap: 8px; width: 100%; cursor: pointer;">
                        <i class="fa-solid fa-right-from-bracket"></i><span>Log out</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>