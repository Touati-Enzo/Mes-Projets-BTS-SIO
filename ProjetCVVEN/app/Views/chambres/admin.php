<?php
$current_page = 'chambres_admin';
?>
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

        .page-title {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
        }

        .page-title h1 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            border-color: #e9ecef;
            vertical-align: middle;
        }

        .table tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .btn-dropdown {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 6px 12px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-dropdown:hover {
            background: var(--secondary-color);
            color: white;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .dropdown-item {
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }

        .footer {
            background: #333;
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-top: 60px;
        }

        .alert {
            border: none;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .empty-state i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 15px;
        }

        .btn-action {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            border: none;
            color: white;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-action:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
        }

        @media (max-width: 768px) {
            .table {
                font-size: 0.875rem;
            }

            .table th,
            .table td {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
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
                    <?php if ($user['role'] === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-2"></i>Gestion
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item active" href="<?= base_url('/chambres/admin') ?>">
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
                            <i class="fas fa-user me-2"></i><?= $user['username'] ?>
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
            <h1><i class="fas fa-door-open me-2"></i><?= $title ?></h1>
            <p class="mb-0">Gérez et modifiez vos chambres</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mb-5">
        <!-- Messages d'alerte -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Bouton Créer -->
        <div class="mb-4">
            <a href="<?= base_url('/chambres/create') ?>" class="btn btn-action">
                <i class="fas fa-plus me-2"></i>Créer une nouvelle chambre
            </a>
        </div>

        <!-- Card conteneur -->
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 20px; border: none;">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Liste de toutes les chambres</h5>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($chambres)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-door-open me-2"></i>Numéro</th>
                                    <th><i class="fas fa-euro-sign me-2"></i>Prix/Jour</th>
                                    <th><i class="fas fa-users me-2"></i>Capacité</th>
                                    <th><i class="fas fa-file-alt me-2"></i>Description</th>
                                    <th><i class="fas fa-cog me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($chambres as $chambre): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($chambre['numero_chambre']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><?= number_format($chambre['prix_journalier'], 2, ',', ' ') ?>€</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?= $chambre['personne_max'] ?> personne(s)</span>
                                        </td>
                                        <td>
                                            <small><?= htmlspecialchars(substr($chambre['description'] ?? 'N/A', 0, 50)) ?>...</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog me-1"></i>Modifier
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#quickEditModal<?= $chambre['id'] ?>">
                                                            <i class="fas fa-lightning-bolt text-warning me-2"></i>Édition rapide
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="<?= base_url('chambres/delete/' . $chambre['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette chambre ?')">
                                                            <i class="fas fa-trash text-danger me-2"></i>Supprimer
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Édition Rapide -->
                                    <div class="modal fade" id="quickEditModal<?= $chambre['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Édition rapide - Chambre <?= htmlspecialchars($chambre['numero_chambre']) ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="<?= base_url('chambres/quickUpdate/' . $chambre['id']) ?>" method="POST">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="numero_chambre" class="form-label">Numéro de chambre</label>
                                                            <input type="text" class="form-control" name="numero_chambre" value="<?= htmlspecialchars($chambre['numero_chambre']) ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="prix_journalier" class="form-label">Prix journalier (€)</label>
                                                            <input type="number" class="form-control" name="prix_journalier" step="0.01" value="<?= $chambre['prix_journalier'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="personne_max" class="form-label">Capacité maximale</label>
                                                            <input type="number" class="form-control" name="personne_max" value="<?= $chambre['personne_max'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($chambre['description'] ?? '') ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save me-2"></i>Enregistrer
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h5>Aucune chambre</h5>
                        <p>Il n'y a actuellement aucune chambre dans le système.</p>
                    </div>
                <?php endif; ?>
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