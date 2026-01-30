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

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 20px;
        }

        .info-group {
            margin-bottom: 20px;
        }

        .info-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .info-value {
            color: #666;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
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
            <h1><i class="fas fa-user-circle me-2"></i><?= $title ?></h1>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mb-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informations de votre profil</h5>
                    </div>
                    <div class="card-body">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Nom d'utilisateur</div>
                            <div class="info-value"><?= $user['username'] ?></div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= $user['email'] ?></div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Prénom</div>
                            <div class="info-value"><?= $user['first_name'] ?? 'Non renseigné' ?></div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Nom</div>
                            <div class="info-value"><?= $user['last_name'] ?? 'Non renseigné' ?></div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('/') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <a href="<?= base_url('/settings') ?>" class="btn btn-primary">
                                <i class="fas fa-cog me-2"></i>Paramètres
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>