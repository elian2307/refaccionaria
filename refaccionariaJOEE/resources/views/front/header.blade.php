<nav class="navbar">

    <div class="logo">JOEE Mechanics</div>

    <div class="menu">
    @auth
        <a href="/dash">
            <i class="fa-solid fa-user-check"></i> {{ Str::before(Auth::user()->nombre, ' ') }}
        </a>
    @endauth

    @guest
        <a href="/login">
            Log In <i class="fa-solid fa-right-to-bracket"></i> 
        </a>
    @endguest
</div>

</nav>