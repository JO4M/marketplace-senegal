<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonnements - Vendeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .pricing-card {
            transition: transform 0.3s;
            cursor: pointer;
        }
        .pricing-card:hover {
            transform: translateY(-10px);
        }
        .pricing-card .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .price {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Vendeur</a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('seller.products.index') }}" class="btn btn-outline-light btn-sm me-2">Mes produits</a>
                <a href="{{ route('seller.subscriptions.index') }}" class="btn btn-light btn-sm me-2">Abonnement</a>
                <span class="navbar-text text-white me-3">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Statut actuel -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3>Votre statut actuel</h3>
            </div>
            <div class="card-body">
                @php
                    $subscription = Auth::user()->activeSubscription;
                    $currentProducts = Auth::user()->products()->count();
                    $maxProducts = Auth::user()->max_products;
                @endphp
                
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Forfait actuel :</strong> 
                            @if($subscription)
                                {{ ucfirst($subscription->plan) }}
                            @else
                                Gratuit
                            @endif
                        </p>
                        <p><strong>Produits :</strong> {{ $currentProducts }} / {{ $maxProducts == PHP_INT_MAX ? 'Illimité' : $maxProducts }}</p>
                        @if($subscription && $subscription->end_date)
                            <p><strong>Expiration :</strong> {{ $subscription->end_date->format('d/m/Y') }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="progress">
                            @php $percentage = ($currentProducts / $maxProducts) * 100; @endphp
                            <div class="progress-bar {{ $percentage > 80 ? 'bg-warning' : 'bg-success' }}" 
                                 style="width: {{ min($percentage, 100) }}%">
                                {{ $currentProducts }}/{{ $maxProducts == PHP_INT_MAX ? '∞' : $maxProducts }}
                            </div>
                        </div>
                        @if(!$subscription && $currentProducts >= 5)
                            <div class="alert alert-warning mt-3">
                                ⚠️ Vous avez atteint la limite de 5 produits. Passez au Premium pour ajouter plus de produits.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Plans d'abonnement -->
        <h2 class="text-center mb-4">Choisissez le plan qui vous convient</h2>
        <div class="row">
            <!-- Plan Gratuit -->
            <div class="col-md-4 mb-4">
                <div class="card pricing-card h-100">
                    <div class="card-header bg-secondary text-white text-center">
                        Basique
                    </div>
                    <div class="card-body text-center">
                        <div class="price">0 FCFA</div>
                        <p class="text-muted">/mois</p>
                        <hr>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Jusqu'à 5 produits</li>
                            <li><i class="fas fa-check text-success"></i> Messagerie standard</li>
                            <li><i class="fas fa-check text-success"></i> Profil vendeur basique</li>
                            <li><i class="fas fa-check text-success"></i> Support par email</li>
                        </ul>
                        @if(!Auth::user()->activeSubscription)
                            <button class="btn btn-secondary" disabled>Plan actuel</button>
                        @else
                            <button class="btn btn-outline-secondary" disabled>Gratuit</button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Plan Premium Pro -->
            <div class="col-md-4 mb-4">
                <div class="card pricing-card h-100 border-primary">
                    <div class="card-header bg-primary text-white text-center">
                        Premium Pro <span class="badge bg-warning">Populaire</span>
                    </div>
                    <div class="card-body text-center">
                        <div class="price">15 000 FCFA</div>
                        <p class="text-muted">/mois</p>
                        <hr>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Produits illimités</li>
                            <li><i class="fas fa-check text-success"></i> Visibilité "À la une"</li>
                            <li><i class="fas fa-check text-success"></i> Badge Vendeur Vérifié</li>
                            <li><i class="fas fa-check text-success"></i> Statistiques de vente</li>
                            <li><i class="fas fa-check text-success"></i> Support WhatsApp 24/7</li>
                            <li><i class="fas fa-check text-success"></i> 0% de commission</li>
                        </ul>
                        <form action="{{ route('seller.subscriptions.subscribe') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="premium_pro">
                            <input type="hidden" name="max_products" value="999999">
                            <input type="hidden" name="price" value="15000">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Souscrire au forfait Premium Pro ? (Paiement simulé)')">
                                Passer au Pro
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Plan Annuel -->
            <div class="col-md-4 mb-4">
                <div class="card pricing-card h-100">
                    <div class="card-header bg-success text-white text-center">
                        Pack Annuel
                    </div>
                    <div class="card-body text-center">
                        <div class="price">150 000 FCFA</div>
                        <p class="text-muted">/an</p>
                        <hr>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Tous les avantages Pro</li>
                            <li><i class="fas fa-check text-success"></i> 2 mois offerts</li>
                            <li><i class="fas fa-check text-success"></i> Accompagnement marketing</li>
                            <li><i class="fas fa-check text-success"></i> Formation photo produit</li>
                            <li><i class="fas fa-check text-success"></i> Accès VIP aux événements</li>
                        </ul>
                        <form action="{{ route('seller.subscriptions.subscribe') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="annual">
                            <input type="hidden" name="max_products" value="999999">
                            <input type="hidden" name="price" value="150000">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Souscrire au Pack Annuel ? (Paiement simulé)')">
                                Choisir l'Annuel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <strong>📱 Modes de paiement acceptés :</strong> Orange Money, Wave, Free Money, Visa/Mastercard (paiement simulé pour la démo)
        </div>
    </div>
</body>
</html>
