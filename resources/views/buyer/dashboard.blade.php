<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Acheteur - Marketplace Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @include('partials.navbar')

    <div class="container mt-4">
        <div class="row">
            <!-- Menu latéral gauche -->
            <div class="col-md-3">
                <div class="list-group mb-4">
                    <a href="{{ route('buyer.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('buyer.claims.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt"></i> Mes réclamations
                    </a>
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-bag"></i> Continuer mes achats
                    </a>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3><i class="fas fa-tachometer-alt"></i> Dashboard Acheteur</h3>
                    </div>
                    <div class="card-body">
                        <h4>Bonjour, {{ Auth::user()->name }} !</h4>
                        <p>Bienvenue dans votre espace acheteur.</p>
                        <hr>

                        @php
                            $claims = App\Models\Claim::where('buyer_id', Auth::id())->get();
                            $pendingClaims = $claims->where('status', 'pending')->count();
                            $resolvedClaims = $claims->where('status', 'resolved')->count();
                        @endphp

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card text-white bg-info">
                                    <div class="card-body">
                                        <h5>Total réclamations</h5>
                                        <h2>{{ $claims->count() }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-white bg-warning">
                                    <div class="card-body">
                                        <h5>En attente</h5>
                                        <h2>{{ $pendingClaims }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-white bg-success">
                                    <div class="card-body">
                                        <h5>Résolues</h5>
                                        <h2>{{ $resolvedClaims }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-secondary">
                            <strong>📋 Liens rapides :</strong>
                            <ul class="mb-0">
                                <li><a href="{{ route('buyer.claims.index') }}">Voir mes réclamations</a></li>
                                <li><a href="{{ route('home') }}">Continuer mes achats</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bouton retour à l'accueil -->
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>