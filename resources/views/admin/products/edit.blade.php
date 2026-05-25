<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier produit - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Marketplace Sénégal - Admin</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text text-white me-3">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-warning">
                <h3>Modifier le produit #{{ $product->id }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label>Nom du produit *</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Catégorie *</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Prix (FCFA) *</label>
                                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Stock *</label>
                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label>Statut produit *</label>
                        <select name="status" class="form-control" required>
                            <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Brouillon</option>
                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="sold" {{ $product->status == 'sold' ? 'selected' : '' }}>Vendu</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="5">{{ $product->description }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
