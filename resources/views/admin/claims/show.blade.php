<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traiter réclamation - Admin</title>
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
            <div class="card-header bg-warning text-white">
                <h3>Réclamation #{{ $claim->id }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informations acheteur</h4>
                        <table class="table">
                            <tr><th>Nom</th><td>{{ $claim->buyer->name }}</td></tr>
                            <tr><th>Email</th><td>{{ $claim->buyer->email }}</td></tr>
                            <tr><th>Téléphone</th><td>{{ $claim->buyer->phone ?? 'Non renseigné' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Informations vendeur</h4>
                        <table class="table">
                            <tr><th>Boutique</th><td>{{ $claim->seller->boutique_name ?? $claim->seller->name }}</td></tr>
                            <tr><th>Email</th><td>{{ $claim->seller->email }}</td></tr>
                            <tr><th>Téléphone</th><td>{{ $claim->seller->phone ?? 'Non renseigné' }}</td></tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <h4>Informations produit</h4>
                        <table class="table">
                            <tr><th>Produit</th><td>{{ $claim->product->name }}</td></tr>
                            <tr><th>Prix</th><td>{{ number_format($claim->product->price, 0, ',', ' ') }} FCFA</td></tr>
                            <tr><th>Numéro commande</th><td>{{ $claim->order_number ?? 'Non renseigné' }}</td></tr>
                            <tr><th>Motif</th>
                                <td>
                                    @switch($claim->reason)
                                        @case('non_livraison') 🚚 Non livraison / retard @break
                                        @case('produit_defectueux') 🔧 Produit défectueux @break
                                        @case('tromperie') 🎭 Tromperie @break
                                        @case('remboursement') 💰 Remboursement @break
                                        @default ❓ {{ $claim->reason }}
                                    @endswitch
                                </td>
                            </tr>
                            <tr><th>Description</th><td>{{ $claim->description }}</td></tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <h4>Gérer la réclamation</h4>
                    <form action="{{ route('admin.claims.update', $claim->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Changer le statut</label>
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ $claim->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="in_progress" {{ $claim->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="resolved" {{ $claim->status == 'resolved' ? 'selected' : '' }}>Résolu - Donner raison à l'acheteur</option>
                                <option value="rejected" {{ $claim->status == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Réponse de l'admin</label>
                            <textarea name="admin_response" class="form-control" rows="5" placeholder="Expliquez la décision à l'acheteur et au vendeur...">{{ $claim->admin_response }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="{{ route('admin.claims.index') }}" class="btn btn-secondary">Retour</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
