<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail produit - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Admin</a>
            <div class="navbar-nav ms-auto">
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
                <h3>Détail du produit #{{ $product->id }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informations produit</h4>
                        <table class="table">
                            <tr><th>Nom</th><td>{{ $product->name }}</td></tr>
                            <tr><th>Catégorie</th><td>{{ $product->category->name }}</td></tr>
                            <tr><th>Prix</th><td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td></tr>
                            <tr><th>Stock</th><td>{{ $product->stock }}</td></tr>
                            <tr><th>Description</th><td>{{ $product->description }}</td></tr>
                            <tr><th>Statut vendeur</th><td>{{ $product->status == 'active' ? 'Actif' : 'Brouillon' }}</td></tr>
                            <tr><th>Visibilité</th>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Visible</span>
                                    @else
                                        <span class="badge bg-danger">Caché</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Vues</th><td>{{ $product->views_count }}</td></tr>
                            <tr><th>Date création</th><td>{{ $product->created_at->format('d/m/Y H:i') }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Informations vendeur</h4>
                        <table class="table">
                            <tr><th>Nom</th><td>{{ $product->user->boutique_name ?? $product->user->name }}</td></tr>
                            <tr><th>Email</th><td>{{ $product->user->email }}</td></tr>
                            <tr><th>Téléphone</th><td>{{ $product->user->phone ?? 'Non renseigné' }}</td></tr>
                            <tr><th>WhatsApp</th><td>{{ $product->user->whatsapp ?? 'Non renseigné' }}</td></tr>
                            <tr><th>Ville</th><td>{{ $product->user->city ?? 'Non renseigné' }}</td></tr>
                        </table>
                        
                        <h4 class="mt-3">Signalements</h4>
                        @php $reports = \App\Models\Report::where('product_id', $product->id)->get(); @endphp
                        @if($reports->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr><th>Acheteur</th><th>Motif</th><th>Statut</th><th>Date</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $report)
                                        <tr>
                                            <td>{{ $report->user->name }}</td>
                                            <td>
                                                @switch($report->reason)
                                                    @case('produit_contrefait') Produit contrefait @break
                                                    @case('photo_trompeuse') Photo trompeuse @break
                                                    @case('prix_abusif') Prix abusif @break
                                                    @case('produit_interdit') Produit interdit @break
                                                    @default {{ $report->reason }}
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($report->status == 'pending')
                                                    <span class="badge bg-warning">En attente</span>
                                                @elseif($report->status == 'resolved')
                                                    <span class="badge bg-success">Résolu</span>
                                                @else
                                                    <span class="badge bg-danger">Rejeté</span>
                                                @endif
                                            </td>
                                            <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Aucun signalement pour ce produit.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('admin.products.toggle-active', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn {{ $product->is_active ? 'btn-danger' : 'btn-success' }}">
                            <i class="fas {{ $product->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            {{ $product->is_active ? 'Cacher le produit' : 'Afficher le produit' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer définitivement ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
