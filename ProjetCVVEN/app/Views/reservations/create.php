<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - ProjetCVVEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #00b4d8;
        }

        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            transition: all 0.3s;
            padding: 10px 15px !important;
            border-radius: 5px;
            margin: 0 5px;
        }

        .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .navbar-text {
            color: rgba(255, 255, 255, 0.8);
        }

        .page-title {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
        }

        .btn-submit {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            border: none;
            color: white;
            font-weight: 500;
        }

        .btn-submit:hover {
            color: white;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
        }

        .price-summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ff6b35;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .price-row:last-child {
            margin-bottom: 0;
            border-top: 2px solid #ddd;
            padding-top: 10px;
            font-weight: 700;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #0066cc 0%, #00b4d8 100%); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="<?= base_url('/') ?>" style="font-weight: 700; color: white !important;">
                <i class="fas fa-calendar-check"></i> ProjetCVVEN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                            <i class="fas fa-home me-2"></i>Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/chambres') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                            <i class="fas fa-door-open me-2"></i>Chambres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/reservations') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                            <i class="fas fa-calendar me-2"></i>Réservations
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500;">
                            <i class="fas fa-user me-2"></i><?= session()->get('username') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('/profile') ?>">
                                    <i class="fas fa-id-card me-2"></i>Mon profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('/settings') ?>">
                                    <i class="fas fa-cog me-2"></i>Paramètres
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Title -->
    <section class="page-title">
        <div class="container">
            <h1><i class="fas fa-plus-circle me-2"></i><?= $title ?></h1>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mb-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Formulaire de réservation</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Erreurs de validation :</h6>
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-times-circle me-2"></i>
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('/reservations/store') ?>" method="post" id="reservationForm">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="num_chambre" class="form-label">
                                    <i class="fas fa-door-open me-2"></i>Chambre *
                                </label>
                                <select class="form-select" id="num_chambre" name="num_chambre" required onchange="updatePrice()">
                                    <option value="">-- Sélectionnez une chambre --</option>
                                    <?php foreach ($chambres as $chambre): ?>
                                        <option value="<?= $chambre['numero_chambre'] ?>"
                                            data-prix="<?= $chambre['prix_journalier'] ?>"
                                            <?= old('num_chambre') == $chambre['numero_chambre'] ? 'selected' : '' ?>>
                                            Chambre <?= $chambre['numero_chambre'] ?> -
                                            <?= number_format($chambre['prix_journalier'], 2, ',', ' ') ?>€/nuit
                                            (Max <?= $chambre['personne_max'] ?> pers.)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_debut" class="form-label">
                                        <i class="fas fa-calendar-check me-2"></i>Date d'arrivée *
                                    </label>
                                    <input type="date"
                                        class="form-control"
                                        id="date_debut"
                                        name="date_debut"
                                        value="<?= old('date_debut') ?>"
                                        min="<?= date('Y-m-d') ?>"
                                        required
                                        onchange="updatePrice()">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="date_fin" class="form-label">
                                        <i class="fas fa-calendar-times me-2"></i>Date de départ *
                                    </label>
                                    <input type="date"
                                        class="form-control"
                                        id="date_fin"
                                        name="date_fin"
                                        value="<?= old('date_fin') ?>"
                                        min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                        required
                                        onchange="updatePrice()">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="nb_personne" class="form-label">
                                    <i class="fas fa-users me-2"></i>Nombre de personnes *
                                </label>
                                <input type="number"
                                    class="form-control"
                                    id="nb_personne"
                                    name="nb_personne"
                                    value="<?= old('nb_personne', '1') ?>"
                                    min="1"
                                    required>
                            </div>

                            <!-- Price Summary -->
                            <div class="price-summary" id="priceSummary" style="display: none;">
                                <div class="price-row">
                                    <span>Prix par nuit :</span>
                                    <span id="pricePerNight">-</span>
                                </div>
                                <div class="price-row">
                                    <span>Nombre de nuits :</span>
                                    <span id="numberOfNights">-</span>
                                </div>
                                <div class="price-row">
                                    <span>Prix total :</span>
                                    <span id="totalPrice" class="text-warning">-</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= base_url('/reservations') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-save me-2"></i>Créer la réservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updatePrice() {
            const chambreSelect = document.getElementById('num_chambre');
            const dateDebut = document.getElementById('date_debut').value;
            const dateFin = document.getElementById('date_fin').value;
            const pricePerNight = chambreSelect.options[chambreSelect.selectedIndex].dataset.prix;

            if (dateDebut && dateFin && pricePerNight) {
                const debut = new Date(dateDebut);
                const fin = new Date(dateFin);
                const timeDiff = Math.abs(fin - debut);
                const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

                if (daysDiff > 0) {
                    const totalPrice = daysDiff * parseFloat(pricePerNight);

                    document.getElementById('priceSummary').style.display = 'block';
                    document.getElementById('pricePerNight').textContent = parseFloat(pricePerNight).toFixed(2) + '€';
                    document.getElementById('numberOfNights').textContent = daysDiff;
                    document.getElementById('totalPrice').textContent = totalPrice.toFixed(2) + '€';
                } else {
                    document.getElementById('priceSummary').style.display = 'none';
                }
            } else {
                document.getElementById('priceSummary').style.display = 'none';
            }
        }

        // Initialiser au chargement
        window.addEventListener('load', updatePrice);
    </script>
</body>

</html>