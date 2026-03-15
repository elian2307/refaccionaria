<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/joee/css/dash.css') }}" />
    <link rel="icon" href="{{ asset('/joee/img/iso.png') }}">

</head>

<body>

    <section class="all">

        @include('dash.layout.aside')

        <main>
            <header>
                <div>
                    <h1 id="thetitle">Dashboard</h1>
                    <p id="descri">Here.</p>
                </div>
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="" id="" placeholder="Search something">
                </div>
            </header>

            <div id="hereNeiga" class="cont">
                @yield('content')
            </div>

        </main>

    </section>

    @include('dash.layout.footer')


    <script src="{{ asset('/joee/js/dash.js') }}"></script>

    @include('dash.layout.modals')

</body>

</html>