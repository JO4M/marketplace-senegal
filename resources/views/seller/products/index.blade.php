<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes produits - Vendeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Vendeur</a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('seller.products.create') }}" class="btn btn-success btn-sm me-2">+ Ajouter produit</a>
                <a href="{{ route('seller.subscriptions.index') }}" class="btn btn-outline-light btn-sm me-2">Abonnement</a>
                <span class="navbar-text text-white me-3">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3>Mes Produits</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($products->isEmpty())
                    <div class="alert alert-info">Vous n'avez pas encore de produits. <a href="{{ route('seller.products.create') }}">Ajoutez votre premier produit</a></div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Nom</th>
                                    <th>Catégorie</th>
                                    <th>Prix (FCFA)</th>
                                    <th>Stock</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        @if($product->main_photo)
                                            <img src="{{ asset('storage/' . $product->main_photo) }}" alt="Photo" style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail">
                                        @else
                                            <img src="https://via.placeholder.com/50" alt="No photo" style="width: 50px;" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ number_format($product->price, 0, ',', ' ') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if($product->status == 'active')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Brouillon</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-warning">Modifier</a>
                                        <form action="{{ route('seller.products.destroy', $product) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                                        </form>
                                        <form action="{{ route('seller.products.toggle-status', $product) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info">
                                                {{ $product->status == 'active' ? 'Désactiver' : 'Activer' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                @endif
            </div>
        </div>
    </div>
</body>
</html>