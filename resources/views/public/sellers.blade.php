<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendeurs - SENEGALSE WARKESHOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @include('partials.navbar')

    <div class="container mt-4">
        <h1 class="mb-4">Nos Vendeurs</h1>
        <p class="text-muted mb-5">Découvrez les artisans et commerçants de la plateforme</p>
        
        <div class="row">
            @foreach($sellers as $seller)
            <div class="col-md-3 col-6 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-store fa-3x mb-3 text-primary"></i>
                        <h5>{{ $seller->boutique_name ?? $seller->name }}</h5>
                        <p class="text-muted">{{ $seller->city ?? 'Localisation' }}</p>
                        <p>{{ $seller->products()->count() }} produits</p>
                        <a href="{{ route('public.seller.profile', $seller->id) }}" class="btn btn-primary btn-sm">Voir la boutique</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{ $sellers->links() }}
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>