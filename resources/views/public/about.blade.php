<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - SENEGALSE WARKESHOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @include('partials.navbar')

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center mb-4">À propos de JAAYAL NU</h1>
                <div class="card">
                    <div class="card-body">
                        <h4>Notre mission</h4>
                        <p>Soutenir l'artisanat et le commerce local au Sénégal grâce au numérique.</p>
                        
                        <h4 class="mt-4">Notre vision</h4>
                        <p>Devenir la première plateforme de mise en relation entre artisans sénégalais et acheteurs du monde entier.</p>
                        
                        <h4 class="mt-4">Notre équipe</h4>
                        <p>Une équipe passionnée par le développement local et l'innovation technologique.</p>
                        
                        <h4 class="mt-4">Contact</h4>
                        <p>
                            <i class="fas fa-map-marker-alt"></i> Dakar, Sénégal<br>
                            <i class="fas fa-phone"></i> +221 33 000 00 00<br>
                            <i class="fas fa-envelope"></i> contact@vitrinenumerique.sn
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>