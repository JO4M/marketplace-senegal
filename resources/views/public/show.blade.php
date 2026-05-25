<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Marketplace Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-store"></i> Marketplace Sénégal
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
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

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                @if($product->main_photo)
                    <img src="{{ asset('storage/' . $product->main_photo) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/500x400" class="img-fluid rounded" alt="{{ $product->name }}">
                @endif
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p class="text-muted">Catégorie : {{ $product->category->name }}</p>
                <h3 class="text-primary">{{ number_format($product->price, 0, ',', ' ') }} FCFA</h3>
                <p class="mt-3">{{ $product->description }}</p>
                <p><strong>Stock disponible :</strong> {{ $product->stock }} unités</p>
                
                <hr>
                <h4>Vendeur : {{ $product->user->boutique_name ?? $product->user->name }}</h4>
                <p><i class="fas fa-map-marker-alt"></i> {{ $product->user->city ?? 'Non renseigné' }}</p>
                
                @if($product->user->whatsapp)
                <a href="https://wa.me/221{{ $product->user->whatsapp }}" target="_blank" class="btn btn-success btn-lg me-2">
                    <i class="fab fa-whatsapp"></i> Contacter sur WhatsApp
                </a>
                @endif
                
                @if($product->user->phone)
                <a href="tel:{{ $product->user->phone }}" class="btn btn-info btn-lg">
                    <i class="fas fa-phone"></i> Appeler
                </a>
                @endif

                <!-- Bouton Signalement -->
                <hr>
                @auth
                    @if(auth()->user()->role != 'seller' || auth()->id() != $product->user_id)
                    <div class="mt-3">
                        <a href="{{ route('report.create', $product->id) }}" class="btn btn-outline-danger">
                            <i class="fas fa-flag"></i> Signaler ce produit
                        </a>
                    </div>
                    @endif
                @else
                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-danger">
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

        @if($similar->count() > 0)
        <div class="row mt-5">
            <h3>Produits similaires</h3>
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

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2026 Marketplace Sénégal - Soutenons l'artisanat local</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>