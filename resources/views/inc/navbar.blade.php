
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{asset("storage/images/IWAlogo.PNG")}}" width="150" height="80" style="padding-right: 30px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="/home" style="font-size: 30px; padding-right: 20px; ">Home</a>
                <a class="nav-link" href="/addAbonnement" style="font-size: 30px; padding-right: 20px;">Abonnement</a>
                @if(isset(Auth::user()->admin)  and Auth::user()->admin == 1)
                <a class="nav-link" href="/addUser" style="font-size: 30px; padding-right: 20px;">Gebruikers</a>
                @endif
            </div>
                <div class="navbar-nav">
                @if(isset(Auth::user()->username))
                <strong style="color: gray; padding: 0.5rem 0.1rem; font-size: 30px;">Welcome {{ Auth::user()->username }}</strong>
                <a class="nav-link float-end"  href="{{ url('/login/logout') }}" style="font-size: 30px;">Logout</a>
                @endif
            </div>
        </div>
    </div>
</nav>
