<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail signalement - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @include('partials.navbar')

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3>Détail du signalement #{{ $report->id }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Produit :</strong> {{ $report->product->name }}</p>
                <p><strong>Signalé par :</strong> {{ $report->user->name }}</p>
                <p><strong>Motif :</strong> {{ $report->reason }}</p>
                <p><strong>Description :</strong> {{ $report->description ?? 'Non fournie' }}</p>
                <p><strong>Statut :</strong> {{ $report->status }}</p>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2026 SENEGALSE WARKESHOP. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>