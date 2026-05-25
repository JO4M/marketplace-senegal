<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamer un produit - Marketplace Sénégal</title>
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3><i class="fas fa-file-alt"></i> Réclamer un produit</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Produit :</strong> {{ $product->name }}<br>
                            <strong>Vendeur :</strong> {{ $product->user->boutique_name ?? $product->user->name }}
                        </div>

                        <form action="{{ route('buyer.claim.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Motif de la réclamation *</label>
                                <select name="reason" class="form-control" required>
                                    <option value="">Sélectionnez un motif</option>
                                    <option value="non_livraison">🚚 Non livraison / retard de livraison</option>
                                    <option value="produit_defectueux">🔧 Produit défectueux / endommagé</option>
                                    <option value="tromperie">🎭 Tromperie (ne correspond pas à la description)</option>
                                    <option value="remboursement">💰 Demande de remboursement</option>
                                    <option value="autre">❓ Autre motif</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Numéro de commande (si disponible)</label>
                                <input type="text" name="order_number" class="form-control" placeholder="Ex: CMD-2024-001">
                                <small class="text-muted">Indiquez votre numéro de commande si vous l'avez</small>
                            </div>
                            <div class="mb-3">
                                <label>Description détaillée *</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Décrivez précisément le problème..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning">Envoyer la réclamation</button>
                            <a href="{{ route('public.product.show', $product->slug) }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
