<nav class="navbar">

    <div class="logo">JOEE Mechanics</div>

    <div class="menu">
    <a href="#">Home</a>
    <a href="#">Repairs</a>
    <a href="#">Sale</a>
    <a href="#">Contact</a>

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