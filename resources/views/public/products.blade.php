<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les produits - Marketplace Sénégal</title>
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
            <!-- Sidebar filtres -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Filtres</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET">
                            <div class="mb-3">
                                <label>Recherche</label>
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                            </div>
                            <div class="mb-3">
                                <label>Catégorie</label>
                                <select name="category" class="form-control">
                                    <option value="">Toutes</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Prix min</label>
                                    <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <label>Prix max</label>
                                    <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 w-100">Filtrer</button>
                            <a href="{{ route('public.products') }}" class="btn btn-secondary mt-2 w-100">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Liste produits -->
            <div class="col-md-9">
                <div class="row">
                    @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if($product->main_photo)
                                <img src="{{ asset('storage/' . $product->main_photo) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                                <p class="card-text"><strong>{{ number_format($product->price, 0, ',', ' ') }} FCFA</strong></p>
                                <a href="{{ route('public.product.show', $product->slug) }}" class="btn btn-primary btn-sm">Voir détails</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">Aucun produit trouvé.</div>
                    </div>
                    @endforelse
                </div>
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2026 Marketplace Sénégal - Soutenons l'artisanat local</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>