<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vendeur - Vitrine Numérique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stat-card {
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .message-item {
            border-left: 3px solid #007bff;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .message-item:hover {
            background: #e9ecef;
        }
        .message-time {
            font-size: 0.75rem;
            color: #6c757d;
        }
        .product-status {
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 20px;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-sold {
            background: #cce5ff;
            color: #004085;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container mt-4">
        <div class="row">
            <!-- Menu latéral gauche -->
            <div class="col-md-3">
                <div class="list-group mb-4">
                    <a href="{{ route('seller.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt"></i> Vue d'ensemble
                    </a>
                    <a href="{{ route('seller.products.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-box"></i> Mes produits
                    </a>
                    <a href="{{ route('seller.products.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle"></i> Ajouter un produit
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-envelope"></i> Messages
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-line"></i> Statistiques
                    </a>
                    <a href="{{ route('seller.subscriptions.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-crown"></i> Abonnement
                    </a>
                </div>

                <!-- Carte Premium -->
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-gem fa-3x mb-2"></i>
                        <h5>Passez au Premium</h5>
                        <p class="small">Booster vos ventes avec une visibilité prioritaire</p>
                        <a href="{{ route('seller.subscriptions.index') }}" class="btn btn-light btn-sm">
                            Découvrir les avantages
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="col-md-9">
                <!-- En-tête -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Bonjour, {{ Auth::user()->name }} !</h2>
                    <p class="text-muted">{{ now()->format('d/m/Y') }}</p>
                </div>
                <p class="text-muted mb-4">Voici ce qui se passe dans votre boutique aujourd'hui.</p>

                @php
                    $products = Auth::user()->products;
                    $totalProducts = $products->count();
                    $totalViews = $products->sum('views_count');
                    $activeProducts = $products->where('status', 'active')->count();
                    $draftProducts = $products->where('status', 'draft')->count();
                    $recentProducts = $products->sortByDesc('created_at')->take(5);
                    $topProducts = $products->sortByDesc('views_count')->take(5);
                    
                    // Messages simulés (à remplacer par de vraies données plus tard)
                    $recentMessages = [
                        ['name' => 'Ibrahima Fall', 'time' => 'Il y a 12 min', 'message' => 'Bonjour, est-ce que le panier en osier est disponible ?'],
                        ['name' => 'Fatou Diop', 'time' => 'Il y a 2h', 'message' => 'Merci beaucoup ! La robe est magnifique, je l\'ai achetée.'],
                        ['name' => 'Moussa Ndiaye', 'time' => 'Il y a 5h', 'message' => 'J\'aimerais commander 5 exemplaires de la robe.'],
                        ['name' => 'Awa Sarr', 'time' => 'Hier', 'message' => 'Le paiement a été envoyé via Orange Money.'],
                        ['name' => 'Omar Gueye', 'time' => 'Hier', 'message' => 'Est-il possible de personnaliser la couleur du pantalon?'],
                    ];
                @endphp

                <!-- Cartes statistiques -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Produits Actifs</h6>
                                        <h2 class="mb-0">{{ $activeProducts }}</h2>
                                        <small>+12% depuis le mois dernier</small>
                                    </div>
                                    <i class="fas fa-box fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Vues Totales</h6>
                                        <h2 class="mb-0">{{ number_format($totalViews, 0, ',', ' ') }}</h2>
                                        <small>+8.4% ces 7 derniers jours</small>
                                    </div>
                                    <i class="fas fa-eye fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Messages</h6>
                                        <h2 class="mb-0">{{ count($recentMessages) }}</h2>
                                        <small>+3 aujourd'hui</small>
                                    </div>
                                    <i class="fas fa-envelope fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Produits récents -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-clock"></i> Produits Récents
                                <span class="float-end"><a href="{{ route('seller.products.index') }}" class="text-decoration-none">Gérer</a></span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Produit</th>
                                                <th>Prix</th>
                                                <th>Vues</th>
                                                <th>Statut</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentProducts as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                                                <td>{{ number_format($product->views_count, 0, ',', ' ') }}</td>
                                                <td>
                                                    @if($product->status == 'active')
                                                        <span class="product-status status-active">Actif</span>
                                                    @elseif($product->status == 'draft')
                                                        <span class="product-status status-pending">En attente</span>
                                                    @else
                                                        <span class="product-status status-sold">Vendu</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages récents -->
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-envelope"></i> Derniers Messages
                                <span class="float-end"><a href="#" class="text-decoration-none">Tous</a></span>
                            </div>
                            <div class="card-body p-0">
                                @foreach($recentMessages as $message)
                                <div class="message-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $message['name'] }}</strong>
                                            <p class="mb-0 small">{{ $message['message'] }}</p>
                                        </div>
                                        <small class="message-time">{{ $message['time'] }}</small>
                                    </div>
                                </div>
                                @endforeach
                                <div class="text-center p-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm">Ouvrir la messagerie</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top produits performants -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-chart-line"></i> Top Produits Performants
                            </div>
                            <div class="card-body">
                                @if($topProducts->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Produit</th>
                                                    <th>Prix</th>
                                                    <th>Vues</th>
                                                    <th>Statut</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($topProducts as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                                                    <td><span class="badge bg-info">{{ number_format($product->views_count, 0, ',', ' ') }}</span></td>
                                                    <td>
                                                        @if($product->status == 'active')
                                                            <span class="badge bg-success">Actif</span>
                                                        @else
                                                            <span class="badge bg-secondary">Brouillon</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted text-center">Aucun produit pour le moment.</p>
                                @endif
                            </div>
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