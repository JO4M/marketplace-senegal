<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitrine Numérique - Artisanat Sénégalais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #1a1a2e !important;
            padding: 1rem 0;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff !important;
        }
        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .btn-light {
            background-color: white;
            color: #667eea;
            font-weight: bold;
        }
        .section-title {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #1a1a2e;
        }
        .section-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
        }
        .category-card {
            background: white;
            border: none;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .category-card i {
            color: #667eea;
            margin-bottom: 15px;
        }
        .category-card h6 {
            font-weight: bold;
            margin-top: 10px;
            color: #1a1a2e;
        }
        .category-card small {
            color: #999;
        }
        .product-card {
            border: none;
            border-radius: 10px;
            transition: box-shadow 0.3s;
            background: white;
        }
        .product-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .product-card .card-body {
            padding: 1.25rem;
        }
        .product-card .category-tag {
            color: #667eea;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .product-card .product-title {
            font-weight: bold;
            margin: 10px 0;
            color: #1a1a2e;
        }
        .product-card .seller-name {
            color: #666;
            font-size: 0.9rem;
        }
        .product-card .price {
            color: #667eea;
            font-weight: bold;
            font-size: 1.1rem;
            margin: 10px 0;
        }
        .btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
        }
        .btn-outline-primary:hover {
            background-color: #667eea;
            border-color: #667eea;
        }
        .seller-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
        }
        .seller-card:hover {
            transform: translateY(-5px);
        }
        .seller-card i {
            color: #667eea;
        }
        .seller-card h5 {
            margin-top: 15px;
            font-weight: bold;
            color: #1a1a2e;
        }
        .rating {
            color: #ffc107;
            margin-top: 10px;
        }
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            margin-top: 50px;
        }
        .cta-section h2 {
            color: white;
            font-weight: bold;
        }
        .cta-section p {
            color: white;
            font-size: 1.1rem;
        }
        .footer {
            background-color: #1a1a2e;
            color: white;
            padding: 50px 0 20px;
        }
        .footer h5 {
            font-weight: bold;
            margin-bottom: 20px;
        }
        .footer a {
            color: #ccc;
            text-decoration: none;
        }
        .footer a:hover {
            color: white;
        }
        .btn-light {
            background-color: white;
            color: #667eea;
            font-weight: 600;
        }
        .btn-outline-light {
            border-color: white;
            color: white;
        }
        .btn-outline-light:hover {
            background-color: white;
            color: #667eea;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
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
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="background: none; border: none;">Déconnexion</button>
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <h1>Découvrez l'Excellence du Savoir-faire Sénégalais</h1>
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
        </div>
    </div>

    <!-- Produits à la une -->
    <div class="container my-5">
        <h2 class="section-title">Produits à la une</h2>
        <p class="section-subtitle">Notre sélection coup de cœur de la semaine.</p>
        <div class="row">
            @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card h-100">
                    <img src="https://via.placeholder.com/300x200/eee/ccc?text=Produit" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <div class="category-tag">{{ $product->category->name }}</div>
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <p class="seller-name">Par {{ $product->user->boutique_name ?? $product->user->name }}</p>
                        <p class="price">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                        <a href="{{ route('public.product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">Voir les détails</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">Aucun produit disponible pour le moment.</div>
            @endforelse
        </div>
    </div>

    <!-- Explorer par catégorie -->
    <div class="container my-5">
        <h2 class="section-title">Explorer par catégorie</h2>
        <p class="section-subtitle">Trouvez exactement ce qu'il vous faut parmi nos univers.</p>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('public.products', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="category-card">
                        <i class="fas fa-{{ $category->icon ?? 'tag' }} fa-2x"></i>
                        <h6>{{ $category->name }}</h6>
                        <small>{{ rand(10, 500) }} articles</small>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Vendeurs populaires -->
    <div class="container my-5">
        <h2 class="section-title">Vendeurs populaires</h2>
        <p class="section-subtitle">Les marchands les mieux notés de la plateforme.</p>
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
                    <i class="fas fa-store fa-3x"></i>
                    <h5>{{ $seller->boutique_name ?? $seller->name }}</h5>
                    <p class="text-muted">{{ $seller->city ?? 'Dakar' }}</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="text-muted ms-1">4.9</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Appel à l'action -->
    <div class="cta-section">
        <div class="container text-center">
            <h2>Vous êtes un artisan ou un marchand ?</h2>
            <p class="lead mt-3">Ouvrez votre boutique en ligne gratuitement et commencez à vendre vos produits à travers tout le Sénégal et au-delà.</p>
            <div class="mt-4">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">Créer ma boutique</a>
                <a href="#" class="btn btn-outline-light btn-lg">En savoir plus</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
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
                        <li><a href="#">Aide & Support</a></li>
                        <li><a href="#">Conditions d'utilisation</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <hr class="mt-3">
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