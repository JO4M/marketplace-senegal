<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories - SENEGALSE WARKESHOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @include('partials.navbar')

    <div class="container mt-4">
        <h1 class="mb-4">Nos Catégories</h1>
        <p class="text-muted mb-5">Découvrez nos produits par catégorie</p>
        
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 col-6 mb-4">
                <a href="{{ route('public.products', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-{{ $category->icon ?? 'tag' }} fa-3x mb-3 text-primary"></i>
                            <h5>{{ $category->name }}</h5>
                            <p class="text-muted">{{ $category->products()->count() }} produits</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>