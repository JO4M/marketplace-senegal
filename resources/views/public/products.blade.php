<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits Artisanaux - Vitrine Numérique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .breadcrumb {
            background: transparent;
            padding: 0;
        }
        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .rating {
            color: #ffc107;
        }
        .filter-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .filter-card .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            font-weight: bold;
        }
        .product-location {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .product-seller {
            font-size: 0.8rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <!-- Breadcrumb -->
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Boutique</li>
            </ol>
        </nav>
    </div>

    <!-- Header page -->
    <div class="container mb-4">
        <h1 class="display-5 fw-bold">Nos Produits Artisanaux</h1>
        <p class="text-muted">Découvrez le savoir-faire unique de nos artisans locaux. Du textile à la décoration, chaque pièce raconte une histoire authentique du Sénégal.</p>
    </div>

    <div class="container">
        <div class="row">
            <!-- Sidebar filtres -->
            <div class="col-md-3">
                <div class="filter-card card">
                    <div class="card-header">
                        <i class="fas fa-filter"></i> Filtres
                    </div>
                    <div class="card-body">
                        <form method="GET" id="filterForm">
                            <!-- Recherche -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Recherche</label>
                                <input type="text" name="search" class="form-control" placeholder="Nom du produit..." value="{{ request('search') }}">
                            </div>

                            <!-- Catégories -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Catégories</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="" id="cat_all" {{ !request('category') ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                    <label class="form-check-label" for="cat_all">Toutes</label>
                                </div>
                                @foreach($categories as $cat)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="{{ $cat->id }}" id="cat_{{ $cat->id }}" {{ request('category') == $cat->id ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                    <label class="form-check-label" for="cat_{{ $cat->id }}">{{ $cat->name }}</label>
                                </div>
                                @endforeach
                            </div>

                            <!-- Fourchette de prix -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Fourchette de prix</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" name="min_price" class="form-control" placeholder="Min FCFA" value="{{ request('min_price') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_price" class="form-control" placeholder="Max FCFA" value="{{ request('max_price') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Villes -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Villes</label>
                                <select name="city" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Toutes les villes</option>
                                    <option value="Dakar" {{ request('city') == 'Dakar' ? 'selected' : '' }}>Dakar</option>
                                    <option value="Thiès" {{ request('city') == 'Thiès' ? 'selected' : '' }}>Thiès</option>
                                    <option value="Saint-Louis" {{ request('city') == 'Saint-Louis' ? 'selected' : '' }}>Saint-Louis</option>
                                    <option value="Ziguinchor" {{ request('city') == 'Ziguinchor' ? 'selected' : '' }}>Ziguinchor</option>
                                    <option value="Touba" {{ request('city') == 'Touba' ? 'selected' : '' }}>Touba</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Appliquer les filtres</button>
                            <a href="{{ route('public.products') }}" class="btn btn-outline-secondary w-100 mt-2">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Liste produits -->
            <div class="col-md-9">
                <!-- Résultats count -->
                <div class="mb-3">
                    <p class="text-muted">Affichage de {{ $products->firstItem() ?? 0 }} à {{ $products->lastItem() ?? 0 }} sur {{ $products->total() }} produits</p>
                </div>

                <div class="row">
                    @forelse($products as $product)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card product-card h-100">
                            @if($product->main_photo)
                                <img src="{{ asset('storage/' . $product->main_photo) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="fw-bold text-primary">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                                <p class="product-location"><i class="fas fa-map-marker-alt"></i> {{ $product->user->city ?? 'Localisation' }}</p>
                                <p class="product-seller">Vendu par: {{ $product->user->boutique_name ?? $product->user->name }}</p>
                                <div class="rating mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-muted">(4.8)</span>
                                </div>
                                <a href="{{ route('public.product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm w-100">Voir détails</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">Aucun produit trouvé.</div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>