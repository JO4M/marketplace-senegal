<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seller->boutique_name ?? $seller->name }} - Vitrine Numérique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .seller-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 60px 0;
        }
        .seller-avatar {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .seller-avatar i {
            font-size: 60px;
            color: #1e3c72;
        }
        .rating {
            color: #ffc107;
        }
        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .category-tabs .nav-link {
            color: #6c757d;
            border: none;
            padding: 10px 20px;
        }
        .category-tabs .nav-link.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            background: transparent;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .info-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .info-card .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <!-- En-tête vendeur -->
    <div class="seller-header">
        <div class="container text-center">
            <div class="seller-avatar">
                <i class="fas fa-store"></i>
            </div>
            <h1 class="display-5 fw-bold">{{ $seller->boutique_name ?? $seller->name }}</h1>
            <p><i class="fas fa-map-marker-alt"></i> {{ $seller->city ?? 'Localisation non renseignée' }}</p>
            <div class="rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="text-white ms-2">4.9 (124 avis)</span>
            </div>
            <p class="mt-2"><i class="fas fa-calendar-alt"></i> Membre depuis {{ $seller->created_at->format('F Y') }}</p>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- Colonne gauche - Description et contact -->
            <div class="col-md-4">
                <!-- À propos -->
                <div class="card info-card">
                    <div class="card-header bg-white">
                        <i class="fas fa-info-circle"></i> À propos de la boutique
                    </div>
                    <div class="card-body">
                        <p>Bienvenue chez <strong>{{ $seller->boutique_name ?? $seller->name }}</strong>. Nous sommes spécialisés dans la création d'objets d'art et de maroquinerie inspirés par les riches traditions du Sénégal.</p>
                        <p>Chaque pièce de notre collection est fabriquée à la main dans notre atelier, en utilisant des matériaux locaux de première qualité.</p>
                        <p class="mb-0">Notre mission est de préserver le savoir-faire ancestral tout en apportant une touche de modernité à nos créations.</p>
                    </div>
                </div>

                <!-- Contact -->
                <div class="card info-card">
                    <div class="card-header bg-white">
                        <i class="fas fa-envelope"></i> Contacter l'Artisan
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Posez vos questions directement au vendeur pour plus de précisions sur les produits.</p>
                        
                        @if($seller->whatsapp)
                        <a href="https://wa.me/221{{ $seller->whatsapp }}" target="_blank" class="btn btn-success w-100 mb-2">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        @endif
                        
                        @if($seller->phone)
                        <button class="btn btn-info w-100" onclick="showPhoneNumber('{{ $seller->phone }}')">
                            <i class="fas fa-phone"></i> Appeler
                        </button>
                        <div id="phoneNumber" class="mt-2" style="display: none;"></div>
                        @endif
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="card info-card">
                    <div class="card-header bg-white">
                        <i class="fas fa-chart-line"></i> Statistiques
                    </div>
                    <div class="card-body">
                        <div class="stat-card mb-2">
                            <h5>Temps de réponse</h5>
                            <h3 class="text-primary">&lt; 2 heures</h3>
                        </div>
                        <div class="stat-card">
                            <h5>Ventes réussies</h5>
                            <h3 class="text-success">{{ $totalSales }}+</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite - Produits -->
            <div class="col-md-8">
                <h3 class="mb-4">Nos Produits</h3>
                
                <!-- Catégories tabs -->
                <ul class="nav category-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-category="all">Tous</a>
                    </li>
                    @php
                        $categories = App\Models\Category::whereHas('products', function($q) use ($seller) {
                            $q->where('user_id', $seller->id)->where('status', 'active');
                        })->get();
                    @endphp
                    @foreach($categories as $cat)
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-category="{{ $cat->id }}">{{ $cat->name }}</a>
                    </li>
                    @endforeach
                </ul>

                <!-- Grille produits -->
                <div class="row" id="products-grid">
                    @forelse($products as $product)
                    <div class="col-md-6 col-lg-4 mb-4 product-item" data-category="{{ $product->category_id }}">
                        <div class="card product-card h-100">
                            @if($product->main_photo)
                                <img src="{{ asset('storage/' . $product->main_photo) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="fw-bold text-primary">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                                <a href="{{ route('public.product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm w-100">Voir détails</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">Aucun produit disponible pour le moment.</div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Vitrine Numérique</h5>
                    <p>Soutenir l'artisanat et le commerce local au Sénégal grâce au numérique.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact</h5>
                    <p>Dakar, Sénégal<br>+221 33 000 00 00<br>contact@vitrinenumérique.sn</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Liens Utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Aide & Support</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-white text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">© 2026 Vitrine Numérique. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPhoneNumber(number) {
            let div = document.getElementById('phoneNumber');
            if (div.style.display === 'none' || div.style.display === '') {
                div.style.display = 'block';
                div.innerHTML = '<a href="tel:' + number + '" class="btn btn-info btn-sm w-100">' + number + '</a>';
            } else {
                div.style.display = 'none';
                div.innerHTML = '';
            }
        }

        // Filtrage par catégorie (simple JS)
        document.querySelectorAll('.category-tabs .nav-link').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const categoryId = this.dataset.category;
                
                // Active le tab
                document.querySelectorAll('.category-tabs .nav-link').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Filtre les produits
                document.querySelectorAll('.product-item').forEach(item => {
                    if (categoryId === 'all' || item.dataset.category === categoryId) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>