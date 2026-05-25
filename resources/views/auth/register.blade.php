<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription - Marketplace Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Inscription</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Nom -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom complet</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rôle : Acheteur ou Vendeur -->
                            <div class="mb-3">
                                <label for="role" class="form-label">Je suis</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="buyer">Acheteur</option>
                                    <option value="seller">Vendeur</option>
                                </select>
                            </div>

                            <!-- Champs spécifiques vendeur (cachés par défaut) -->
                            <div id="seller-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="boutique_name" class="form-label">Nom de la boutique</label>
                                    <input id="boutique_name" type="text" class="form-control" name="boutique_name">
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input id="phone" type="tel" class="form-control" name="phone">
                                </div>

                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp (optionnel)</label>
                                    <input id="whatsapp" type="tel" class="form-control" name="whatsapp">
                                </div>

                                <div class="mb-3">
                                    <label for="city" class="form-label">Ville</label>
                                    <select id="city" name="city" class="form-control">
                                        <option value="">Sélectionnez votre ville</option>
                                        <option value="Dakar">Dakar</option>
                                        <option value="Thiès">Thiès</option>
                                        <option value="Saint-Louis">Saint-Louis</option>
                                        <option value="Ziguinchor">Ziguinchor</option>
                                        <option value="Touba">Touba</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Mot de passe -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">S'inscrire</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}">Déjà inscrit ? Se connecter</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const sellerFields = document.getElementById('seller-fields');

        roleSelect.addEventListener('change', function() {
            if (this.value === 'seller') {
                sellerFields.style.display = 'block';
                // Rendre les champs requis
                document.getElementById('boutique_name').required = true;
                document.getElementById('phone').required = true;
                document.getElementById('city').required = true;
            } else {
                sellerFields.style.display = 'none';
                document.getElementById('boutique_name').required = false;
                document.getElementById('phone').required = false;
                document.getElementById('city').required = false;
            }
        });
    </script>
</body>
</html>