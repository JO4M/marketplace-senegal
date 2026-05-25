<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes réclamations - Marketplace Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Marketplace Sénégal</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('buyer.claims.index') }}">Mes réclamations</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-file-alt"></i> Mes réclamations</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($claims->isEmpty())
                    <div class="alert alert-info">Vous n'avez aucune réclamation.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produit</th>
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
                                    <td>{{ $claim->product->name }}</td>
                                    <td>{{ $claim->seller->boutique_name ?? $claim->seller->name }}</td>
                                    <td>
                                        @switch($claim->reason)
                                            @case('non_livraison') Non livraison @break
                                            @case('produit_defectueux') Produit défectueux @break
                                            @case('tromperie') Tromperie @break
                                            @case('remboursement') Remboursement @break
                                            @default {{ $claim->reason }}
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
                                        <a href="{{ route('buyer.claims.show', $claim->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $claims->links() }}
                @endif
            </div>
        </div>
    </div>
</body>
</html>
