<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Marketplace Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Admin</a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light btn-sm me-2">Catégories</a>
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
                <h3>Dashboard Administrateur</h3>
            </div>
            <div class="card-body">
                <h4>Bienvenue, {{ Auth::user()->name }} !</h4>
                <p>Vous êtes connecté en tant qu'<strong>administrateur</strong> de la plateforme.</p>
                <hr>
                <div class="alert alert-info">
                    ✅ Cette zone est réservée à la gestion globale de la marketplace.
                </div>
                <h5>Fonctionnalités :</h5>
                <ul>
                     <li><a href="{{ route('admin.categories.index') }}">Gestion des catégories</a></li>
                     <li><a href="{{ route('admin.vendeurs.index') }}">Gestion des vendeurs (validation, suspension)</a></li>
                     <li><a href="{{ route('admin.products.index') }}">Gestion des produits (tous les produits de la plateforme)</a></li>
                     <li><a href="{{ route('admin.claims.index') }}">Gestion des réclamations acheteurs</a></li>
                     <li>Modération des produits signalés - À venir</li>
                     <li>Statistiques de la plateforme - À venir</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>