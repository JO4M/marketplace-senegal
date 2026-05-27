<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit - Vendeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @include('partials.navbar')

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3>Ajouter un produit</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Nom du produit *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Catégorie *</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Sélectionnez</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Description *</label>
                        <textarea name="description" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Prix (FCFA) *</label>
                                <input type="number" name="price" class="form-control" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Stock *</label>
                                <input type="number" name="stock" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Photo principale</label>
                        <input type="file" name="main_photo" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="text-muted">Formats acceptés : JPG, PNG, GIF, WEBP (max 2MB)</small>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Créer le produit</button>
                    <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2026 SENEGALSE WARKESHOP. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>