<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title> 
    
    <link rel="icon" href="{{ asset('/joee/img/iso.png') }}">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('/joee/css/log.css') }}" />

</head>
<body>
    <div id="app" class="all">
        <nav>
                <a href="{{ url('/') }}">
                    <span>
                         < Go back
                    </span>
                </a>
                        @guest
                            @if (Route::has('login'))
                                    <a class="{{ Route::is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                    <span>
                                        {{ __('Log In') }}
                                    </span></a>
                            @endif

                            @if (Route::has('register'))
                                    <a class="{{ Route::is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                                    <span>
                                        {{ __('Register') }}
                                    </span>
                                    </a>
                            @endif
                        @endguest
        </nav>

        <main>

        <div class="logo">
        <img src="{{ asset('/joee/img/iso.png') }}" alt="">
        <span>{{ config('app.name', 'Laravel') }}</span>
        </div>
            @yield('content')
        </main>
    </div>
    @include('front.footer')
</body>
</html>
