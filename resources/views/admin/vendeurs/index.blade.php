<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des vendeurs - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Admin</a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light btn-sm me-2">Catégories</a>
                <a href="{{ route('admin.vendeurs.index') }}" class="btn btn-light btn-sm me-2">Vendeurs</a>
                <span class="navbar-text text-white me-3">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
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
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        @if(session('danger'))
            <div class="alert alert-danger">{{ session('danger') }}</div>
        @endif

        <!-- Vendeurs en attente -->
        <div class="card mb-4">
            <div class="card-header bg-warning">
                <h3><i class="fas fa-clock"></i> Vendeurs en attente de validation</h3>
            </div>
            <div class="card-body">
                @if($pendingVendeurs->isEmpty())
                    <div class="alert alert-success">✅ Aucun vendeur en attente.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Boutique</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Ville</th>
                                    <th>Date inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingVendeurs as $vendeur)
                                <tr>
                                    <td>{{ $vendeur->id }}</td>
                                    <td>{{ $vendeur->boutique_name ?? '-' }}</td>
                                    <td>{{ $vendeur->name }}</td>
                                    <td>{{ $vendeur->email }}</td>
                                    <td>{{ $vendeur->phone ?? '-' }}</td>
                                    <td>{{ $vendeur->city ?? '-' }}</td>
                                    <td>{{ $vendeur->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('admin.vendeurs.approve', $vendeur->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Valider ce vendeur ?')">
                                                <i class="fas fa-check"></i> Approuver
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.vendeurs.show', $vendeur->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $pendingVendeurs->appends(['pending_page' => $pendingVendeurs->currentPage()])->links() }}
                @endif
            </div>
        </div>

        <!-- Vendeurs actifs -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3><i class="fas fa-check-circle"></i> Vendeurs actifs</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Boutique</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Ville</th>
                                <th>Produits</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeVendeurs as $vendeur)
                            <tr>
                                <td>{{ $vendeur->id }}</td>
                                <td>{{ $vendeur->boutique_name ?? '-' }}</td>
                                <td>{{ $vendeur->name }}</td>
                                <td>{{ $vendeur->email }}</td>
                                <td>{{ $vendeur->phone ?? '-' }}</td>
                                <td>{{ $vendeur->city ?? '-' }}</td>
                                <td>{{ $vendeur->products->count() }}</td>
                                <td>
                                    <form action="{{ route('admin.vendeurs.suspend', $vendeur->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Suspendre ce vendeur ?')">
                                            <i class="fas fa-pause"></i> Suspendre
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.vendeurs.show', $vendeur->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                    <form action="{{ route('admin.vendeurs.destroy', $vendeur->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer définitivement ce vendeur ?')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $activeVendeurs->appends(['active_page' => $activeVendeurs->currentPage()])->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
