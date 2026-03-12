<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | JOEE Mechanics</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/joee/css/dash.css') }}" />
    <link rel="icon" href="{{ asset('/joee/img/iso.png') }}">

</head>

<body>

    <section class="all">
        <aside>
            <div class="logo">
                <img src="{{ asset('/joee/img/iso.png') }}" alt="">
                <span>JOEE MECHANICS</span>
            </div>
            <nav>
                <ul>
                    <li class="selectedf"><i class="fa-solid fa-clipboard-list"></i><span>Dashboard</span></li>
                    <li><i class="fa-solid fa-chart-line"></i><span>Statics</span></li>
                    <li><i class="fa-solid fa-users"></i><span>Users</span></li>
                    <li><i class="fa-solid fa-box-open"></i><span>Orders</span></li>
                    <li><i class="fa-solid fa-tags"></i><span>Offers</span></li>
                    <li><i class="fa-solid fa-gavel"></i><span>Auctions</span></li>
                    <li><i class="fa-solid fa-bullhorn"></i><span>Reviews</span></li>   
                    <li><i class="fa-solid fa-gear"></i><span>Settings</span></li>
                </ul>
                <ul >
                    <li><i class="fa-solid fa-house"></i> Home</li>
                    <li class="dan"><i class="fa-solid fa-right-from-bracket"></i> Log out</li>
                </ul>
            </nav>
        </aside>

        <main>
            <header>
                <div>
                    <h1>Control Panel</h1>
                    <p>Welcome back.</p>
                </div>
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Search something</span>
                </div>
            </header>

            <section class="stats-grid">
                <div class="card">
                    <h3>Total Sales</h3>
                    <p class="value">$24,500</p>
                    <p class="trend"><i class="fa-solid fa-arrow-up"></i> +12% this month</p>
                </div>
                <div class="card">
                    <h3>New clients</h3>
                    <p class="value">1,240</p>
                    <p class="trend"><i class="fa-solid fa-arrow-up"></i> +5% this month</p>
                </div>
                <div class="card">
                    <h3>Rentability</h3>
                    <p class="value">24.8%</p>
                    <p class="trend dan"><i class="fa-solid fa-arrow-down"></i> -2% today</p>
                </div>
            </section>

            <section class="table-container">
                <h2>USERS</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Fiscal ID</th>
                            <th>Reputation</th>
                            <th>Phone Number</th>
                            <th>Premium</th>
                            <th>Join date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Orlando</td>
                            <td>orlando@example.com</td>
                            <td class="sec">Admin</td>
                            <td>MOVO12344444</td>
                            <td>4.5</td>
                            <td>123456789</td>
                            <td class="suc">Activated</td>
                            <td>2026-03-12</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>

    </section>
    <footer>
        <span>
            JOEE Mechanics - Easier than ever.
        </span>
        <span>
            English (US)
        </span>
        <div class="somedia">
            <a href="https://www.facebook.com"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.messenger.com"><i class="fa-brands fa-facebook-messenger"></i></a>
            <a href="https://www.instagram.com"><i class="fa-brands fa-square-instagram"></i></a>
            <a href="https://www.outlook.com"><i class="fa-solid fa-envelope"></i></a>
        </div>
    </footer>



</body>

</html>