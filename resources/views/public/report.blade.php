<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signaler un produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Marketplace Sénégal</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Signaler un produit</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <strong>Produit :</strong> {{ $product->name }}<br>
                            <strong>Vendeur :</strong> {{ $product->user->boutique_name ?? $product->user->name }}
                        </div>
                        
                        <form action="{{ route('report.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Motif du signalement *</label>
                                <select name="reason" class="form-control" required>
                                    <option value="">Sélectionnez un motif</option>
                                    <option value="produit_contrefait">Produit contrefait / faux</option>
                                    <option value="photo_trompeuse">Photo trompeuse</option>
                                    <option value="prix_abusif">Prix abusif</option>
                                    <option value="produit_interdit">Produit interdit / illégal</option>
                                    <option value="autre">Autre motif</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Description détaillée (optionnelle)</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Expliquez pourquoi vous signalez ce produit..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Envoyer le signalement</button>
                            <a href="{{ route('public.product.show', $product->slug) }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
