<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signalements - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @include('partials.navbar')

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3><i class="fas fa-flag"></i> Signalements des produits</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produit</th>
                                <th>Signalé par</th>
                                <th>Motif</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>
                                    <strong>{{ $report->product->name }}</strong><br>
                                    <small>Vendeur: {{ $report->product->user->boutique_name ?? $report->product->user->name }}</small>
                                </td>
                                <td>{{ $report->user->name }}<br><small>{{ $report->user->email }}</small></td>
                                <td>
                                    @switch($report->reason)
                                        @case('produit_contrefait') Produit contrefait @break
                                        @case('photo_trompeuse') Photo trompeuse @break
                                        @case('prix_abusif') Prix abusif @break
                                        @case('produit_interdit') Produit interdit @break
                                        @default {{ $report->reason }}
                                    @endswitch
                                </td>
                                <td>
                                    @if($report->status == 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($report->status == 'resolved')
                                        <span class="badge bg-success">Résolu</span>
                                    @elseif($report->status == 'rejected')
                                        <span class="badge bg-danger">Rejeté</span>
                                    @else
                                        <span class="badge bg-info">Examiné</span>
                                    @endif
                                </td>
                                <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun signalement</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $reports->links() }}
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