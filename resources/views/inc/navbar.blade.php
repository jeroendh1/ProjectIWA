<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">IWA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="/home">Home</a>
<<<<<<< Updated upstream
                <a class="nav-link" href="#">Features</a>
=======
                <a class="nav-link" href="/addAbonnement">Abonnement</a>
                <a class="nav-link" href="/addUser">Gebruikers</a>
>>>>>>> Stashed changes
            </div>
                <div class="navbar-nav">
                @if(isset(Auth::user()->username))
                <strong style="color: gray; padding: 0.5rem 0.1rem">Welcome {{ Auth::user()->username }}</strong>
                <a class="nav-link float-end"  href="{{ url('/login/logout') }}">logout</a>
                @endif
            </div>
        </div>
    </div>
</nav>
