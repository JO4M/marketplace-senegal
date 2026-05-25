<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail réclamation - Marketplace Sénégal</title>
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
                <h3>Réclamation #{{ $claim->id }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informations produit</h4>
                        <table class="table">
                            <tr><th>Produit</th><td>{{ $claim->product->name }}</td></tr>
                            <tr><th>Vendeur</th><td>{{ $claim->seller->boutique_name ?? $claim->seller->name }}</td></tr>
                            <tr><th>Date commande</th><td>{{ $claim->order_number ?? 'Non renseigné' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Statut de la réclamation</h4>
                        <table class="table">
                            <tr><th>Motif</th>
                                <td>
                                    @switch($claim->reason)
                                        @case('non_livraison') Non livraison @break
                                        @case('produit_defectueux') Produit défectueux @break
                                        @case('tromperie') Tromperie @break
                                        @case('remboursement') Remboursement @break
                                        @default {{ $claim->reason }}
                                    @endswitch
                                </td>
                            </tr>
                            <tr><th>Statut</th>
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
                            </tr>
                            <tr><th>Date</th><td>{{ $claim->created_at->format('d/m/Y H:i') }}</td></tr>
                        70
                    </div>
                </div>

                <div class="mt-3">
                    <h4>Description</h4>
                    <div class="alert alert-secondary">
                        {{ $claim->description }}
                    </div>
                </div>

                @if($claim->admin_response)
                <div class="mt-3">
                    <h4>Réponse de l'administrateur</h4>
                    <div class="alert alert-info">
                        {{ $claim->admin_response }}
                        @if($claim->resolved_at)
                            <br><small>Répondu le {{ $claim->resolved_at->format('d/m/Y H:i') }}</small>
                        @endif
                    </div>
                </div>
                @endif

                <div class="mt-3">
                    <a href="{{ route('buyer.claims.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
