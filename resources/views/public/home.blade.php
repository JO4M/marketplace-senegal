<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitrine Numérique - Artisanat Sénégalais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 80px 0;
        }
        .category-card {
            transition: transform 0.3s;
            cursor: pointer;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
        .product-card {
            transition: box-shadow 0.3s;
        }
        .product-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .seller-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }
        .seller-card:hover {
            transform: translateY(-5px);
        }
        .rating {
            color: #ffc107;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-store"></i> Vitrine Numérique
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.products') }}">Catégories</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.products') }}">Vendeurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">À propos</a></li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        @if(auth()->user()->role == 'seller')
                            <li class="nav-item"><a class="nav-link" href="{{ route('seller.products.index') }}">Dashboard</a></li>
                        @elseif(auth()->user()->role == 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.categories.index') }}">Admin</a></li>
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

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Découvrez l'Excellence du Savoir-faire Sénégalais</h1>
            <p class="lead mb-4">Rejoignez la plus grande plateforme dédiée aux artisans et commerçants locaux.<br>Des produits authentiques, directement de leurs ateliers à votre porte.</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Que recherchez-vous ? (Tissu, bijoux...)" id="searchInput">
                        <input type="text" class="form-control form-control-lg" placeholder="Localisation">
                        <button class="btn btn-light btn-lg" onclick="searchProducts()">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits à la une -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Produits à la une</h2>
        <p class="text-center text-muted mb-5">Notre sélection coup de cœur de la semaine.</p>
        <div class="row">
            @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card h-100">
                    @if($product->main_photo)
                        <img src="{{ asset('storage/' . $product->main_photo) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <small class="text-muted">{{ $product->category->name }}</small>
                        <h5 class="card-title mt-2">{{ $product->name }}</h5>
                        <p class="card-text text-muted small">Par {{ $product->user->boutique_name ?? $product->user->name }}</p>
                        <p class="card-text fw-bold text-primary">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                        <a href="{{ route('public.product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">Voir les détails</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">Aucun produit disponible pour le moment.</div>
            @endforelse
        </div>
    </div>

    <!-- Catégories -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Explorer par catégorie</h2>
        <p class="text-center text-muted mb-5">Trouvez exactement ce qu'il vous faut parmi nos univers.</p>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('public.products', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="category-card card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-{{ $category->icon ?? 'tag' }} fa-3x mb-3 text-primary"></i>
                            <h6 class="fw-bold">{{ $category->name }}</h6>
                            <small class="text-muted">{{ rand(10, 500) }} articles</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Vendeurs populaires -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Vendeurs populaires</h2>
        <p class="text-center text-muted mb-5">Les marchands les mieux notés de la plateforme.</p>
        <div class="row">
            @php
                $popularSellers = App\Models\User::where('role', 'seller')
                    ->where('is_active', true)
                    ->take(4)
                    ->get();
            @endphp
            @foreach($popularSellers as $seller)
            <div class="col-md-3 mb-4">
                <div class="seller-card">
                    <i class="fas fa-store fa-3x mb-3 text-primary"></i>
                    <h5>{{ $seller->boutique_name ?? $seller->name }}</h5>
                    <p class="text-muted small">{{ $seller->city ?? 'Localisation' }}</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="text-muted">(4.9)</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Appel à l'action pour les vendeurs -->
    <div class="bg-primary text-white py-5 mt-5">
        <div class="container text-center">
            <h2 class="mb-3">Vous êtes un artisan ou un marchand ?</h2>
            <p class="lead mb-4">Ouvrez votre boutique en ligne gratuitement et commencez à vendre vos produits à travers tout le Sénégal et au-delà.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">Créer ma boutique</a>
            <a href="#" class="btn btn-outline-light btn-lg">En savoir plus</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Vitrine Numérique</h5>
                    <p>Soutenir l'artisanat et le commerce local au Sénégal grâce au numérique.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact</h5>
                    <p>Dakar, Sénégal<br>+221 33 000 00 00<br>contact@vitrinenumerique.sn</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Liens Utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Aide & Support</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-white text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">© 2026 Vitrine Numérique. Tous droits réservés. Made with ❤️</p>
            </div>
        </div>
    </footer>

    <script>
        function searchProducts() {
            let search = document.getElementById('searchInput').value;
            if (search) {
                window.location.href = "{{ route('public.products') }}?search=" + encodeURIComponent(search);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>