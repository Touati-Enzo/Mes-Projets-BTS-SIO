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

        /* Hero section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
            margin-bottom: 40px;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.9;
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

        .card-body {
            padding: 25px;
        }

        .welcome-card {
            text-align: center;
        }

        .welcome-card .user-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: white;
        }

        .welcome-card h3 {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .welcome-card p {
            color: #666;
            margin-bottom: 5px;
        }

        /* Action cards */
        .action-card {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }

        .action-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .action-card h4 {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .action-card p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .btn-action {
            background: linear-gradient(135deg, #0066cc 0%, #00b4d8 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 14px;
            border-radius: 6px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin: auto auto 0 auto;
            font-size: 0.95rem;
            width: fit-content;
            line-height: 1;
        }

        .btn-action i {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .btn-action:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }

        /* Footer */
        .footer {
            background: #333;
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-top: 60px;
        }

        .footer p {
            margin: 0;
        }

        /* Quick stats */
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-card .stat-label {
            color: #666;
            font-weight: 500;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="fas fa-calendar-check"></i>ProjetCVVEN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                            <i class="fas fa-home me-2"></i>Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/chambres') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                            <i class="fas fa-door-open me-2"></i>Chambres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/reservations') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                            <i class="fas fa-calendar me-2"></i>Réservations
                        </a>
                    </li>
                    <?php if ($user['role'] === 'admin'): ?>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1><i class="fas fa-wave-square me-3"></i>Bienvenue, <?= $user['first_name'] ?> !</h1>
            <p>Système de gestion des réservations - ProjetCVVEN</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mb-5">
        <!-- Welcome Card -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <div class="card welcome-card">
                    <div class="card-header">
                        <h5><i class="fas fa-info-circle me-2"></i>Informations utilisateur</h5>
                    </div>
                    <div class="card-body">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3><?= ($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '') ?: $user['username'] ?></h3>
                        <p><strong>Nom d'utilisateur :</strong> <?= $user['username'] ?></p>
                        <p><strong>Email :</strong> <?= $user['email'] ?></p>
                        <p><strong>Rôle :</strong> <span class="badge bg-primary"><?= ucfirst($user['role']) ?></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="action-card">
                    <i class="fas fa-calendar-plus"></i>
                    <h4>Nouvelle réservation</h4>
                    <p>Créez une nouvelle réservation rapidement et facilement.</p>
                    <a href="<?= base_url('/reservations/create') ?>" class="btn btn-action">
                        <i class="fas fa-plus me-2"></i>Créer
                    </a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="action-card">
                    <i class="fas fa-list"></i>
                    <h4>Mes réservations</h4>
                    <p>Consultez l'historique de vos réservations.</p>
                    <a href="<?= base_url('/reservations') ?>" class="btn btn-action">
                        <i class="fas fa-eye me-2"></i>Voir
                    </a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="action-card">
                    <i class="fas fa-door-open"></i>
                    <h4>Consulter les chambres</h4>
                    <p>Découvrez les chambres disponibles pour réserver.</p>
                    <a href="<?= base_url('/chambres') ?>" class="btn btn-action">
                        <i class="fas fa-eye me-2"></i>Voir
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin Management Section (Admin Only) -->
        <?php if ($user['role'] === 'admin'): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 style="color: #0066cc; margin-bottom: 20px;">
                        <i class="fas fa-shield-alt me-2"></i>Gestion d'Administration
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="action-card" style="border-left: 4px solid #0066cc;">
                        <i class="fas fa-door-open" style="color: #0066cc; font-size: 2.5rem;"></i>
                        <h4>Gestion des Chambres</h4>
                        <p>Créez, modifiez et supprimez les chambres de votre établissement.</p>
                        <a href="<?= base_url('/chambres/admin') ?>" class="btn btn-action">
                            <i class="fas fa-sliders-h me-2"></i>Gérer les chambres
                        </a>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="action-card" style="border-left: 4px solid #00b4d8;">
                        <i class="fas fa-tasks" style="color: #00b4d8; font-size: 2.5rem;"></i>
                        <h4>Gestion des Réservations</h4>
                        <p>Consultez et modifiez le statut de toutes les réservations clients.</p>
                        <a href="<?= base_url('/reservations/admin') ?>" class="btn btn-action">
                            <i class="fas fa-list me-2"></i>Gérer les réservations
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Quick Stats -->
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number">0</div>
                    <div class="stat-label">Réservations totales</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number">0</div>
                    <div class="stat-label">En attente</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number">0</div>
                    <div class="stat-label">Confirmées</div>
                </div>
            </div>
        </div>

        <!-- Information Box -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-lightbulb me-2"></i>À savoir</h5>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Vous pouvez créer, modifier et annuler vos réservations à tout moment.</li>
                            <li>Une confirmation sera envoyée à votre adresse email après chaque réservation.</li>
                            <li>Les modifications doivent être effectuées au moins 24 heures avant la date prévue.</li>
                            <li>Pour toute question, n'hésitez pas à nous contacter.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> ProjetCVVEN. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>