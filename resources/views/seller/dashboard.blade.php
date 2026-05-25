<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vendeur - Marketplace Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Vendeur</a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('seller.products.index') }}" class="btn btn-outline-light btn-sm me-2">Mes produits</a>
                <a href="{{ route('seller.products.create') }}" class="btn btn-success btn-sm me-2">+ Ajouter produit</a>
                <a href="{{ route('seller.subscriptions.index') }}" class="btn btn-outline-light btn-sm me-2">Abonnement</a>
                <span class="navbar-text text-white me-3">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @php
            $products = Auth::user()->products;
            $totalProducts = $products->count();
            $totalViews = $products->sum('views_count');
            $activeProducts = $products->where('status', 'active')->count();
            $draftProducts = $products->where('status', 'draft')->count();
            $topProducts = $products->sortByDesc('views_count')->take(5);
        @endphp

        <!-- Cartes statistiques -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Total Produits</h6>
                                <h2 class="mb-0">{{ $totalProducts }}</h2>
                            </div>
                            <i class="fas fa-box fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Produits Actifs</h6>
                                <h2 class="mb-0">{{ $activeProducts }}</h2>
                            </div>
                            <i class="fas fa-check-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Brouillons</h6>
                                <h2 class="mb-0">{{ $draftProducts }}</h2>
                            </div>
                            <i class="fas fa-pencil-alt fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Vues Totales</h6>
                                <h2 class="mb-0">{{ number_format($totalViews, 0, ',', ' ') }}</h2>
                            </div>
                            <i class="fas fa-eye fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Top produits -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="fas fa-chart-line"></i> Top Produits Performants</h5>
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
                                            <td>
                                                <span class="badge bg-info">{{ number_format($product->views_count, 0, ',', ' ') }}</span>
                                            </td>
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

            <!-- Graphique des vues -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="fas fa-chart-bar"></i> Visibilité des produits</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="viewsChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations boutique -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5><i class="fas fa-store"></i> Informations boutique</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Nom :</strong> {{ Auth::user()->boutique_name ?? 'Non renseigné' }}</p>
                                <p><strong>Téléphone :</strong> {{ Auth::user()->phone ?? 'Non renseigné' }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>WhatsApp :</strong> {{ Auth::user()->whatsapp ?? 'Non renseigné' }}</p>
                                <p><strong>Ville :</strong> {{ Auth::user()->city ?? 'Non renseigné' }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Statut :</strong> 
                                    @if(Auth::user()->is_active)
                                        <span class="badge bg-success">✓ Compte actif</span>
                                    @else
                                        <span class="badge bg-warning">⏳ En attente de validation</span>
                                    @endif
                                </p>
                                <p><strong>Membre depuis :</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Graphique des vues
        const ctx = document.getElementById('viewsChart').getContext('2d');
        const products = @json($topProducts->pluck('name'));
        const views = @json($topProducts->pluck('views_count'));
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: products,
                datasets: [{
                    label: 'Nombre de vues',
                    data: views,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Vues'
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' vues';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>