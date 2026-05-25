<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des produits - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Admin</a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light btn-sm me-2">Catégories</a>
                <a href="{{ route('admin.vendeurs.index') }}" class="btn btn-outline-light btn-sm me-2">Vendeurs</a>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-light btn-sm me-2">Signalements</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm me-2">Produits</a>
                <span class="navbar-text text-white me-3">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-box"></i> Gestion des produits</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produit</th>
                                <th>Vendeur</th>
                                <th>Catégorie</th>
                                <th>Prix</th>
                                <th>Stock</th>
                                <th>Statut</th>
                                <th>Signalements</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <strong>{{ $product->name }}</strong><br>
                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                </td>
                                <td>
                                    {{ $product->user->boutique_name ?? $product->user->name }}<br>
                                    <small>{{ $product->user->email }}</small>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if($product->status == 'active')
                                        <span class="badge bg-success">Actif</span>
                                    @elseif($product->status == 'draft')
                                        <span class="badge bg-secondary">Brouillon</span>
                                    @else
                                        <span class="badge bg-warning">Vendu</span>
                                    @endif
                                    <br>
                                    @if($product->is_active)
                                        <span class="badge bg-info">Visible</span>
                                    @else
                                        <span class="badge bg-danger">Caché</span>
                                    @endif
                                </td>
                                <td>
                                    @php $reportCount = \App\Models\Report::where('product_id', $product->id)->count(); @endphp
                                    @if($reportCount > 0)
                                        <span class="badge bg-danger">{{ $reportCount }} signalement(s)</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ route('admin.products.toggle-active', $product->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $product->is_active ? 'btn-danger' : 'btn-success' }}">
                                            <i class="fas {{ $product->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            {{ $product->is_active ? 'Cacher' : 'Afficher' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer définitivement ce produit ?')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</body>
</html>
