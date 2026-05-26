<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catégories - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .stat-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 15px;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .quick-add-card {
            background: #f8f9fa;
            border-radius: 15px;
        }
        .table-categories tbody tr {
            cursor: pointer;
        }
        .table-categories tbody tr:hover {
            background-color: #f5f5f5;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
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
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt"></i> Tableau de Bord
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action active">
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
                    <h2>Gestion des Catégories</h2>
                    <p class="text-muted">Gérez la taxonomie de la plateforme pour faciliter la recherche de produits.</p>
                </div>

                @php
                    $totalCategories = App\Models\Category::count();
                    $activeCategories = App\Models\Category::where('is_active', true)->count();
                    $newCategoriesThisMonth = App\Models\Category::whereMonth('created_at', now()->month)->count();
                    $totalProducts = App\Models\Product::count();
                @endphp

                <!-- Cartes statistiques -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Catégories</h6>
                                        <h2 class="mb-0">{{ $totalCategories }}</h2>
                                        <small>+{{ $newCategoriesThisMonth }} ce mois-ci</small>
                                    </div>
                                    <i class="fas fa-tags fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Catégories Actives</h6>
                                        <h2 class="mb-0">{{ $activeCategories }}</h2>
                                        <small>sur {{ $totalCategories }} total</small>
                                    </div>
                                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Produits</h6>
                                        <h2 class="mb-0">{{ number_format($totalProducts, 0, ',', ' ') }}</h2>
                                        <small>dans toutes les catégories</small>
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
                                        <h6 class="card-title">Produits/Catégorie</h6>
                                        <h2 class="mb-0">{{ $totalCategories > 0 ? round($totalProducts / $totalCategories, 0) : 0 }}</h2>
                                        <small>moyenne</small>
                                    </div>
                                    <i class="fas fa-chart-line fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Liste des catégories -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-list"></i> Liste des Catégories
                                <span class="float-end text-muted small">Tous les segments de marché actuels</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-categories mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Catégorie</th>
                                                <th>Produits</th>
                                                <th>Date Création</th>
                                                <th>Statut</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $category)
                                            <tr>
                                                <td>
                                                    <strong>{{ $category->name }}</strong>
                                                    @if($category->description)
                                                        <br><small class="text-muted">{{ Str::limit($category->description, 40) }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $category->products()->count() }} produits</td>
                                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($category->is_active)
                                                        <span class="status-badge status-active">Actif</span>
                                                    @else
                                                        <span class="status-badge status-inactive">Inactif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Supprimer cette catégorie ?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                 </td>
                                             </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3">
                                    {{ $categories->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ajout rapide -->
                    <div class="col-md-5">
                        <div class="card quick-add-card">
                            <div class="card-header bg-white fw-bold">
                                <i class="fas fa-plus-circle"></i> Ajout Rapide
                                <span class="float-end text-muted small">Créez une nouvelle catégorie en un clic</span>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.categories.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom de la catégorie</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Maroquinerie" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Décrivez brièvement le type de produits..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Icône (Nom Lucide)</label>
                                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Ex: ShoppingBag, Star, Home">
                                        <small class="text-muted">Exemples: ShoppingBag, Star, Home, Tag, Heart</small>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-save"></i> Créer la catégorie
                                    </button>
                                </form>
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