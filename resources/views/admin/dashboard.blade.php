<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Marketplace Sénégal</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags"></i> Gestion des catégories
                    </a>
                    <a href="{{ route('admin.vendeurs.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users"></i> Gestion des vendeurs
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-boxes"></i> Gestion des produits
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-flag"></i> Signalements
                    </a>
                    <a href="{{ route('admin.claims.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt"></i> Réclamations
                    </a>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3><i class="fas fa-tachometer-alt"></i> Dashboard Administrateur</h3>
                    </div>
                    <div class="card-body">
                        <h4>Bienvenue, {{ Auth::user()->name }} !</h4>
                        <p>Vous êtes connecté en tant qu'<strong>administrateur</strong> de la plateforme.</p>
                        <hr>
                        <div class="alert alert-info">
                            ✅ Cette zone est réservée à la gestion globale de la marketplace.
                        </div>
                        <h5>Fonctionnalités disponibles :</h5>
                        <ul>
                            <li><i class="fas fa-tags"></i> <a href="{{ route('admin.categories.index') }}">Gestion des catégories</a></li>
                            <li><i class="fas fa-users"></i> <a href="{{ route('admin.vendeurs.index') }}">Gestion des vendeurs (validation, suspension)</a></li>
                            <li><i class="fas fa-boxes"></i> <a href="{{ route('admin.products.index') }}">Gestion des produits (tous les produits)</a></li>
                            <li><i class="fas fa-flag"></i> <a href="{{ route('admin.reports.index') }}">Signalements des produits</a></li>
                            <li><i class="fas fa-file-alt"></i> <a href="{{ route('admin.claims.index') }}">Gestion des réclamations acheteurs</a></li>
                            <li><i class="fas fa-chart-line"></i> Statistiques de la plateforme - À venir</li>
                        </ul>
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