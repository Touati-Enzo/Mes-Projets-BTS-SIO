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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #666;
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
                    <?php if (session()->get('role') === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500;">
                                <i class="fas fa-cog me-2"></i>Gestion
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('/chambres/admin') ?>">
                                        <i class="fas fa-door-open me-2"></i>Gestion des chambres
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('/reservations/admin') ?>">
                                        <i class="fas fa-list me-2"></i>Gestion des réservations
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
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
            <h1><i class="fas fa-calendar me-2"></i><?= $title ?></h1>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Liste de mes réservations</h5>
                            </div>
                            <div class="col-auto">
                                <a href="<?= base_url('/reservations/create') ?>" class="btn btn-light btn-sm">
                                    <i class="fas fa-plus me-2"></i>Nouvelle réservation
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($reservations)): ?>
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h3>Aucune réservation</h3>
                                <p class="text-muted">Vous n'avez pas encore créé de réservation. Commencez par en créer une !</p>
                                <a href="<?= base_url('/reservations/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Créer une réservation
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($reservations as $reservation): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100" style="border-left: 5px solid #ff6b35;">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span class="badge bg-secondary"><?= esc($reservation['num_chambre']) ?></span>
                                                        <p class="text-muted small mt-2">
                                                            <i class="fas fa-calendar me-2"></i>
                                                            <?= date('d/m/Y', strtotime($reservation['date_debut'])) ?> -
                                                            <?= date('d/m/Y', strtotime($reservation['date_fin'])) ?>
                                                        </p>
                                                        <p class="text-muted small">
                                                            <i class="fas fa-users me-2"></i><?= $reservation['nb_personne'] ?> personne(s)
                                                        </p>
                                                    </div>
                                                    <div class="text-end">
                                                        <h5 style="color: #ff6b35;"><?= number_format($reservation['prix'], 2, ',', ' ') ?>€</h5>
                                                        <small class="text-muted">Prix total</small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="d-flex gap-2">
                                                    <a href="<?= base_url('/reservations/detail/' . $reservation['id']) ?>" class="btn btn-sm btn-info text-white">
                                                        <i class="fas fa-eye me-1"></i>Détails
                                                    </a>
                                                    <a href="<?= base_url('/reservations/cancel/' . $reservation['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                                        <i class="fas fa-trash me-1"></i>Annuler
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>