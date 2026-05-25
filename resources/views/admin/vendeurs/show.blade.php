<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails vendeur - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Admin</a>
            <div class="navbar-nav ms-auto">
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
            <div class="card-header bg-primary text-white">
                <h3>Détails du vendeur</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informations personnelles</h4>
                        <table class="table">
                            <tr><th>Nom complet</th><td>{{ $vendeur->name }}</td></tr>
                            <tr><th>Email</th><td>{{ $vendeur->email }}</td></tr>
                            <tr><th>Téléphone</th><td>{{ $vendeur->phone ?? 'Non renseigné' }}</td></tr>
                            <tr><th>WhatsApp</th><td>{{ $vendeur->whatsapp ?? 'Non renseigné' }}</td></tr>
                            <tr><th>Date inscription</th><td>{{ $vendeur->created_at->format('d/m/Y H:i') }}</td></tr>
                            <tr><th>Statut</th>
                                <td>
                                    @if($vendeur->is_active)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-warning">En attente</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Informations boutique</h4>
                        <table class="table">
                            <tr><th>Nom boutique</th><td>{{ $vendeur->boutique_name ?? 'Non renseigné' }}</td></tr>
                            <tr><th>Ville</th><td>{{ $vendeur->city ?? 'Non renseigné' }}</td></tr>
                            <tr><th>Adresse</th><td>{{ $vendeur->address ?? 'Non renseigné' }}</td></tr>
                            <tr><th>Nombre produits</th><td>{{ $vendeur->products->count() }}</td></tr>
                        </table>
                    </div>
                </div>

                <h4 class="mt-4">Produits du vendeur</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Stock</th>
                                <th>Statut</th>
                                <th>Vues</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendeur->products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if($product->status == 'active')
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-secondary">Brouillon</span>
                                    @endif
                                </td>
                                <td>{{ $product->views_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.vendeurs.index') }}" class="btn btn-secondary">Retour</a>
                    
                    @if(!$vendeur->is_active)
                        <form action="{{ route('admin.vendeurs.approve', $vendeur->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success">Approuver le vendeur</button>
                        </form>
                    @else
                        <form action="{{ route('admin.vendeurs.suspend', $vendeur->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-warning">Suspendre</button>
                        </form>
                    @endif
                    
                    <form action="{{ route('admin.vendeurs.destroy', $vendeur->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer définitivement ?')">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
