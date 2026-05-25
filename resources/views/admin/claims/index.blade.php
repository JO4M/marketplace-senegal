<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamations - Admin</title>
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
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light btn-sm me-2">Produits</a>
                <a href="{{ route('admin.claims.index') }}" class="btn btn-light btn-sm me-2">Réclamations</a>
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
                <h3><i class="fas fa-file-alt"></i> Gestion des réclamations</h3>
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
                                <th>Acheteur</th>
                                <th>Vendeur</th>
                                <th>Motif</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($claims as $claim)
                            <tr>
                                <td>{{ $claim->id }}</td>
                                <td>{{ $claim->product->name }}<br><small>{{ number_format($claim->product->price, 0, ',', ' ') }} FCFA</small></td>
                                <td>{{ $claim->buyer->name }}<br><small>{{ $claim->buyer->email }}</small></td>
                                <td>{{ $claim->seller->boutique_name ?? $claim->seller->name }}</td>
                                <td>
                                    @switch($claim->reason)
                                        @case('non_livraison') 🚚 Non livraison @break
                                        @case('produit_defectueux') 🔧 Produit défectueux @break
                                        @case('tromperie') 🎭 Tromperie @break
                                        @case('remboursement') 💰 Remboursement @break
                                        @default ❓ {{ $claim->reason }}
                                    @endswitch
                                </td>
                                <td>
                                    @if($claim->status == 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($claim->status == 'in_progress')
                                        <span class="badge bg-info">En cours</span>
                                    @elseif($claim->status == 'resolved')
                                        <span class="badge bg-success">Résolu</span>
                                    @else
                                        <span class="badge bg-danger">Rejeté</span>
                                    @endif
                                </td>
                                <td>{{ $claim->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.claims.show', $claim->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Traiter
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $claims->links() }}
            </div>
        </div>
    </div>
</body>
</html>
