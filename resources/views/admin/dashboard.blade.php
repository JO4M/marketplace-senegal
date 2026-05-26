<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Vitrine Numérique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stat-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 15px;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .activity-item {
            border-left: 3px solid #007bff;
            margin-bottom: 15px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .activity-item:hover {
            background: #e9ecef;
        }
        .activity-time {
            font-size: 0.7rem;
            color: #6c757d;
        }
        .pending-table tbody tr {
            cursor: pointer;
        }
        .pending-table tbody tr:hover {
            background: #fff3cd;
        }
        .growth-chart {
            max-height: 300px;
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
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt"></i> Tableau de Bord
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags"></i> Catégories
                    </a>
                    <a href="{{ route('admin.vendeurs.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users"></i> Vendeurs
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-boxes"></i> Produits
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
                <!-- En-tête -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Tableau de Bord</h2>
                    <p class="text-muted">{{ now()->format('d/m/Y H:i') }}</p>
                </div>
                <p class="text-muted mb-4">Bienvenue, {{ Auth::user()->name }}. Voici l'état actuel de votre plateforme.</p>

                @php
                    // Statistiques
                    $totalUsers = App\Models\User::count();
                    $totalSellers = App\Models\User::where('role', 'seller')->count();
                    $totalBuyers = App\Models\User::where('role', 'buyer')->count();
                    $totalProducts = App\Models\Product::count();
                    $activeProducts = App\Models\Product::where('status', 'active')->count();
                    $totalReports = App\Models\Report::where('status', 'pending')->count();
                    $totalClaims = App\Models\Claim::where('status', 'pending')->count();
                    $totalRevenue = 1250000; // Simulation
                    
                    // Vendeurs en attente
                    $pendingSellers = App\Models\User::where('role', 'seller')
                        ->where('is_active', false)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                    
                    // Activités récentes (simulées)
                    $recentActivities = [
                        ['user' => 'Moussa Diop', 'action' => "s'est inscrit comme vendeur", 'time' => now()->subMinutes(2)],
                        ['user' => 'Artisanat Thiès', 'action' => 'a souscrit au Pack Gold', 'time' => now()->subMinutes(15)],
                        ['user' => 'Fatou Ndiaye', 'action' => 'a ajouté 5 nouveaux produits', 'time' => now()->subHour()],
                        ['user' => 'Modérateur System', 'action' => 'Signalement : Produit inapproprié', 'time' => now()->subHours(3)],
                        ['user' => 'Khadim Tall', 'action' => 'nouvel utilisateur public', 'time' => now()->subHours(5)],
                    ];
                    
                    // Données pour le graphique (simulées)
                    $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'];
                    $usersData = [8500, 9200, 10100, 11200, 11800, 12450];
                    $sellersData = [520, 610, 700, 780, 810, 842];
                @endphp

                <!-- Cartes statistiques -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Utilisateurs</h6>
                                        <h2 class="mb-0">{{ number_format($totalUsers, 0, ',', ' ') }}</h2>
                                        <small>dont {{ $totalSellers }} vendeurs</small>
                                    </div>
                                    <i class="fas fa-users fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Produits</h6>
                                        <h2 class="mb-0">{{ number_format($totalProducts, 0, ',', ' ') }}</h2>
                                        <small>{{ $activeProducts }} actifs</small>
                                    </div>
                                    <i class="fas fa-boxes fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-warning text-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Signalements</h6>
                                        <h2 class="mb-0">{{ $totalReports }}</h2>
                                        <small>en attente</small>
                                    </div>
                                    <i class="fas fa-flag fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Chiffre d'affaires</h6>
                                        <h2 class="mb-0">{{ number_format($totalRevenue, 0, ',', ' ') }} FCFA</h2>
                                        <small>+18% ce mois</small>
                                    </div>
                                    <i class="fas fa-chart-line fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Graphique croissance -->
                    <div class="col-md-7 mb-4">
                        <div class="card">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-chart-line"></i> Croissance de la Plateforme
                                <span class="float-end text-muted small">Évolution des utilisateurs et vendeurs sur les 6 derniers mois</span>
                            </div>
                            <div class="card-body">
                                <canvas id="growthChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Activité récente -->
                    <div class="col-md-5 mb-4">
                        <div class="card">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-history"></i> Activité Récente
                                <span class="float-end"><a href="#" class="text-decoration-none">Voir tout</a></span>
                            </div>
                            <div class="card-body p-0">
                                @foreach($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $activity['user'] }}</strong>
                                            <p class="mb-0 small">{{ $activity['action'] }}</p>
                                        </div>
                                        <small class="activity-time">{{ $activity['time']->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vendeurs en attente -->
                <div class="card mb-4">
                    <div class="card-header bg-warning fw-bold">
                        <i class="fas fa-clock"></i> Vendeurs en attente de validation
                        <span class="float-end"><a href="{{ route('admin.vendeurs.index') }}" class="text-decoration-none">Gérer toutes les validations</a></span>
                    </div>
                    <div class="card-body p-0">
                        @if($pendingSellers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover pending-table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Boutique / Artisan</th>
                                            <th>Catégorie</th>
                                            <th>Date d'inscription</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingSellers as $seller)
                                        <tr>
                                            <td>{{ $seller->boutique_name ?? $seller->name }}</td>
                                            <td>{{ $seller->category_name ?? 'Non renseignée' }}</td>
                                            <td>{{ $seller->created_at->format('d M Y') }}</td>
                                            <td><span class="badge bg-warning">En attente</span></td>
                                            <td>
                                                <a href="{{ route('admin.vendeurs.show', $seller->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Détails
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center p-4">
                                <p class="text-muted mb-0">Aucun vendeur en attente de validation.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Bouton retour à l'accueil -->
                <div class="mt-2 mb-4">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Graphique de croissance
        const ctx = document.getElementById('growthChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [
                    {
                        label: 'Utilisateurs',
                        data: @json($usersData),
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Vendeurs',
                        data: @json($sellersData),
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre d\'utilisateurs'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>