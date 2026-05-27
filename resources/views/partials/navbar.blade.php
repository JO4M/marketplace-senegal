<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fas fa-store"></i> JAAYAL NU
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('public.products') }}">Tous les produits</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('public.products') }}">Catégories</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('public.products') }}">Vendeurs</a></li>
                <li class="nav-item"><a class="nav-link" href="#">À propos</a></li>
            </ul>
            <ul class="navbar-nav">
                @auth
                    @if(auth()->user()->role == 'seller')
                        <li class="nav-item"><a class="nav-link" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                    @elseif(auth()->user()->role == 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                    @elseif(auth()->user()->role == 'buyer')
                        <li class="nav-item"><a class="nav-link" href="{{ route('buyer.dashboard') }}">Dashboard</a></li>
                    @endif
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">S'inscrire</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
