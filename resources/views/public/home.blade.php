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
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .product-card {
            transition: box-shadow 0.3s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
        .section-header {
            position: relative;
            margin-bottom: 40px;
        }
        .section-header h2 {
            font-size: 2rem;
            font-weight: bold;
        }
        .view-all {
            position: absolute;
            right: 0;
            bottom: 0;
        }
        @media (max-width: 768px) {
            .view-all {
                position: static;
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

    @include('partials.navbar')

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
        <div class="section-header">
            <h2 class="text-center mb-4">Produits à la une</h2>
            <p class="text-center text-muted mb-4">Notre sélection coup de cœur de la semaine.</p>
            <div class="text-center">
                <a href="{{ route('public.products') }}" class="btn btn-outline-primary">
                    Voir tout le catalogue <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
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
                        <p class="card-text text-muted small">Par {{ $product->user->boutique_name ?? $product->user->name }}</p>
                        <h5 class="card-title">{{ $product->name }}</h5>
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
                            <small class="text-muted">{{ $category->products()->where('status', 'active')->count() }} articles</small>
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
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© 2026 Vitrine Numérique. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white me-3"><i class="fab fa-linkedin fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                </div>
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