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

        /* Navbar styling */
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
            transition: all 0.3s;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
        }

        .chambre-card {
            display: flex;
            flex-direction: column;
        }

        .chambre-card .card-body {
            flex-grow: 1;
        }

        .prix {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ff6b35;
            margin: 10px 0;
        }

        .btn-action {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            border: none;
            color: white;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-action:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .btn-secondary {
            color: white;
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

        .badge-capacity {
            background: #00b4d8;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
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
                        <a class="nav-link active" href="<?= base_url('/chambres') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                            <i class="fas fa-door-open me-2"></i>Chambres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/reservations') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
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
            <div class="row align-items-center">
                <div class="col">
                    <h1><i class="fas fa-door-open me-2"></i><?= $title ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mb-5">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($chambres)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Aucune chambre disponible</h3>
                <p class="text-muted">Il n'y a pas encore de chambres enregistrées.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($chambres as $chambre): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card chambre-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-door-open me-2"></i>Chambre <?= $chambre['numero_chambre'] ?>
                                </h5>

                                <div class="prix"><?= number_format($chambre['prix_journalier'], 2, ',', ' ') ?>€/nuit</div>

                                <p class="card-text text-muted">
                                    <?= $chambre['description'] ?? 'Pas de description disponible' ?>
                                </p>

                                <div class="mb-3">
                                    <span class="badge-capacity">
                                        <i class="fas fa-users me-1"></i><?= $chambre['personne_max'] ?> personne(s) max
                                    </span>
                                </div>
                            </div>

                            <div class="card-footer bg-light border-top-0">
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('/chambres/detail/' . $chambre['id']) ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Détails
                                    </a>
                                    <a href="<?= base_url('/reservations/create') ?>" class="btn btn-action btn-sm">
                                        <i class="fas fa-calendar-plus me-1"></i>Réserver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>