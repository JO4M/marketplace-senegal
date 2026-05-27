<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Vitrine Numérique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .badge-fait-main {
            background-color: #8B4513;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.75rem;
            display: inline-block;
        }
        .badge-populaire {
            background-color: #ffc107;
            color: #000;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.75rem;
            display: inline-block;
        }
        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 1.2rem;
            margin-right: 10px;
        }
        .current-price {
            color: #007bff;
            font-size: 2rem;
            font-weight: bold;
        }
        .rating {
            color: #ffc107;
        }
        .seller-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
        }
        .btn-contact {
            padding: 12px 20px;
            font-size: 1rem;
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
                <li class="breadcrumb-item"><a href="{{ route('public.products') }}">Boutique</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Colonne image -->
            <div class="col-md-6">
                @if($product->main_photo)
                    <img src="{{ asset('storage/' . $product->main_photo) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/500x400" class="img-fluid rounded" alt="{{ $product->name }}">
                @endif
            </div>

            <!-- Colonne infos produit -->
            <div class="col-md-6">
                <!-- Badges -->
                <div class="mb-3">
                    <span class="badge-fait-main me-2">
                        <i class="fas fa-hand-sparkles"></i> FAIT MAIN
                    </span>
                    @if($product->views_count > 100)
                    <span class="badge-populaire">
                        <i class="fas fa-fire"></i> Populaire
                    </span>
                    @endif
                </div>

                <!-- Stock et statut -->
                <div class="mb-2">
                    @if($product->stock > 0)
                        <span class="text-success"><i class="fas fa-check-circle"></i> En stock</span>
                    @else
                        <span class="text-danger"><i class="fas fa-times-circle"></i> Rupture de stock</span>
                    @endif
                </div>

                <h1 class="display-6 fw-bold">{{ $product->name }}</h1>
                <p class="text-muted">Catégorie : {{ $product->category->name }}</p>

                <!-- Prix -->
                <div class="mb-3">
                    <span class="current-price">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                </div>

                <!-- Boutons contact -->
                <div class="row mt-4">
                    @if($product->user->whatsapp)
                    <div class="col-md-6 mb-2">
                        <a href="https://wa.me/221{{ $product->user->whatsapp }}" target="_blank" class="btn btn-success w-100 btn-contact">
                            <i class="fab fa-whatsapp"></i> Contacter sur WhatsApp
                        </a>
                    </div>
                    @endif
                    
                    @if($product->user->phone)
                    <div class="col-md-6 mb-2">
                        <button class="btn btn-info w-100 btn-contact" onclick="showPhoneNumber('{{ $product->user->phone }}')">
                            <i class="fas fa-phone"></i> Appeler
                        </button>
                        <div id="phoneNumber" class="mt-2" style="display: none;"></div>
                    </div>
                    @endif
                </div>

                <!-- Mention conditions -->
                <p class="text-muted small mt-3">
                    En contactant le vendeur, vous acceptez nos conditions de mise en relation.
                </p>

                <!-- Description -->
                <hr>
                <p class="mt-3">{{ $product->description }}</p>

                <!-- Bouton Signalement -->
                @auth
                    @if(auth()->user()->role != 'seller' || auth()->id() != $product->user_id)
                    <div class="mt-3">
                        <a href="{{ route('report.create', $product->id) }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-flag"></i> Signaler ce produit
                        </a>
                    </div>
                    @endif
                @else
                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-flag"></i> Connectez-vous pour signaler
                        </a>
                    </div>
                @endauth

                <!-- Bouton Réclamation -->
                @auth
                    @if(auth()->user()->role == 'buyer')
                    <div class="mt-2">
                        <a href="{{ route('buyer.claim.create', $product->id) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-file-alt"></i> Réclamer (commande non conformé)
                        </a>
                    </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Section Vendeur -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <i class="fas fa-store fa-4x text-primary"></i>
                            </div>
                            <div class="col-md-5">
                                <h4>{{ $product->user->boutique_name ?? $product->user->name }}</h4>
                                <p><i class="fas fa-map-marker-alt"></i> {{ $product->user->city ?? 'Localisation non renseignée' }}</p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-muted">4.9 (128 avis)</span>
                                </div>
                                <p class="text-muted small">Membre depuis {{ $product->user->created_at->format('F Y') }}</p>
                            </div>
                            <div class="col-md-5">
                                <p>Spécialiste de l'artisanat local. Chaque pièce est unique et faite à la main avec amour.</p>
                                <a href="#" class="btn btn-primary">Voir la boutique complète</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produits similaires -->
        @if($similar->count() > 0)
        <div class="row mt-5">
            <h3 class="mb-4">Produits similaires</h3>
            @foreach($similar as $similarProduct)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($similarProduct->main_photo)
                        <img src="{{ asset('storage/' . $similarProduct->main_photo) }}" class="card-img-top" alt="{{ $similarProduct->name }}" style="height: 150px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/150x150" class="card-img-top" alt="{{ $similarProduct->name }}">
                    @endif
                    <div class="card-body">
                        <h6>{{ $similarProduct->name }}</h6>
                        <p><strong>{{ number_format($similarProduct->price, 0, ',', ' ') }} FCFA</strong></p>
                        <a href="{{ route('public.product.show', $similarProduct->slug) }}" class="btn btn-sm btn-primary">Voir</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2026 JAAYAL NU. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPhoneNumber(number) {
            let div = document.getElementById('phoneNumber');
            if (div.style.display === 'none' || div.style.display === '') {
                div.style.display = 'block';
                div.innerHTML = '<a href="tel:' + number + '" class="btn btn-info btn-sm">' + number + '</a>';
            } else {
                div.style.display = 'none';
                div.innerHTML = '';
            }
        }
    </script>
</body>
</html>