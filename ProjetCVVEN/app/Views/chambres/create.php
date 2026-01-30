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
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="fas fa-calendar-check"></i> ProjetCVVEN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/') ?>">
                            <i class="fas fa-home me-2"></i>Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/chambres') ?>">
                            <i class="fas fa-door-open me-2"></i>Chambres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/reservations') ?>">
                            <i class="fas fa-calendar me-2"></i>Réservations
                        </a>
                    </li>
                    <?php if (session()->get('role') === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
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
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
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
                        <h5 class="mb-0">Formulaire de création</h5>
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

                        <form action="<?= base_url('/chambres/store') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="numero_chambre" class="form-label">
                                    <i class="fas fa-key me-2"></i>Numéro de chambre *
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="numero_chambre"
                                    name="numero_chambre"
                                    value="<?= old('numero_chambre') ?>"
                                    placeholder="Ex: 101, 202, etc."
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="prix_journalier" class="form-label">
                                    <i class="fas fa-euro-sign me-2"></i>Prix par nuit (€) *
                                </label>
                                <input type="number"
                                    step="0.01"
                                    class="form-control"
                                    id="prix_journalier"
                                    name="prix_journalier"
                                    value="<?= old('prix_journalier') ?>"
                                    placeholder="Ex: 80.00"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="personne_max" class="form-label">
                                    <i class="fas fa-users me-2"></i>Capacité (nombre de personnes) *
                                </label>
                                <input type="number"
                                    class="form-control"
                                    id="personne_max"
                                    name="personne_max"
                                    value="<?= old('personne_max') ?>"
                                    placeholder="Ex: 2, 4, etc."
                                    min="1"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left me-2"></i>Description
                                </label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="4"
                                    placeholder="Décrivez la chambre (équipements, vue, etc.)..."><?= old('description') ?></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= base_url('/chambres') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-save me-2"></i>Créer la chambre
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>