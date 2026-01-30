<?php
$current_page = 'reservations_admin';
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

        .badge-attente {
            background-color: #ffc107;
            color: #000;
        }

        .badge-confirmee {
            background-color: #28a745;
            color: white;
        }

        .badge-annulee {
            background-color: #dc3545;
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.875rem;
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

        .form-inline {
            gap: 10px;
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
                                    <a class="dropdown-item" href="<?= base_url('/chambres/admin') ?>">
                                        <i class="fas fa-door-open me-2"></i>Gestion des chambres
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item active" href="<?= base_url('/reservations/admin') ?>">
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
            <h1><i class="fas fa-list me-2"></i><?= $title ?></h1>
            <p class="mb-0">Gérez toutes les réservations de vos clients</p>
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

        <!-- Card conteneur -->
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 20px; border: none;">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Liste de toutes les réservations</h5>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($reservations)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user me-2"></i>Client</th>
                                    <th><i class="fas fa-door-open me-2"></i>Chambre</th>
                                    <th><i class="fas fa-calendar-alt me-2"></i>Dates</th>
                                    <th><i class="fas fa-users me-2"></i>Personnes</th>
                                    <th><i class="fas fa-euro-sign me-2"></i>Prix</th>
                                    <th><i class="fas fa-info-circle me-2"></i>Statut</th>
                                    <th><i class="fas fa-cog me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservations as $reservation): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($reservation['first_name'] ?? $reservation['username']) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($reservation['email'] ?? '') ?></small>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($reservation['numero_chambre'] ?? 'N/A') ?></strong>
                                        </td>
                                        <td>
                                            <small>
                                                <i class="fas fa-arrow-right"></i><br>
                                                <?= date('d/m/Y', strtotime($reservation['date_debut'])) ?><br>
                                                <i class="fas fa-arrow-left"></i><br>
                                                <?= date('d/m/Y', strtotime($reservation['date_fin'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?= $reservation['nb_personne'] ?></span>
                                        </td>
                                        <td>
                                            <strong><?= number_format($reservation['prix'], 2, ',', ' ') ?>€</strong>
                                        </td>
                                        <td>
                                            <?php
                                            $statut = $reservation['statut'] ?? 'en_attente';
                                            $badgeClass = match ($statut) {
                                                'confirmee' => 'badge-confirmee',
                                                'annulee' => 'badge-annulee',
                                                default => 'badge-attente'
                                            };
                                            $statutLabel = match ($statut) {
                                                'confirmee' => 'Confirmée',
                                                'annulee' => 'Annulée',
                                                default => 'En attente'
                                            };
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= $statutLabel ?></span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Dropdown Statut -->
                                                <div class="dropdown">
                                                    <button class="btn-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-info-circle me-1"></i>Statut
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="<?= base_url('reservations/updateStatut/' . $reservation['id']) ?>" method="POST" style="display:inline;">
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Passer en attente ?')">
                                                                    <i class="fas fa-clock text-warning me-2"></i>En attente
                                                                </button>
                                                                <input type="hidden" name="statut" value="en_attente">
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="<?= base_url('reservations/updateStatut/' . $reservation['id']) ?>" method="POST" style="display:inline;">
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Confirmer cette réservation ?')">
                                                                    <i class="fas fa-check text-success me-2"></i>Confirmée
                                                                </button>
                                                                <input type="hidden" name="statut" value="confirmee">
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="<?= base_url('reservations/updateStatut/' . $reservation['id']) ?>" method="POST" style="display:inline;">
                                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Annuler cette réservation ?')">
                                                                    <i class="fas fa-times text-danger me-2"></i>Annulée
                                                                </button>
                                                                <input type="hidden" name="statut" value="annulee">
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- Dropdown Modifier -->
                                                <div class="dropdown">
                                                    <button class="btn-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-cog me-1"></i>Modifier
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#quickEditModal<?= $reservation['id'] ?>">
                                                                <i class="fas fa-lightning-bolt text-warning me-2"></i>Édition rapide
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="<?= base_url('reservations/delete/' . $reservation['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
                                                                <i class="fas fa-trash-alt text-danger me-2"></i>Supprimer
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Édition Rapide -->
                                    <div class="modal fade" id="quickEditModal<?= $reservation['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Édition rapide - Réservation #<?= htmlspecialchars($reservation['id']) ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="<?= base_url('reservations/quickUpdate/' . $reservation['id']) ?>" method="POST">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="num_chambre" class="form-label">Chambre</label>
                                                            <select class="form-control chambre-select" name="num_chambre" id="num_chambre_<?= $reservation['id'] ?>" required>
                                                                <option value="">-- Sélectionner une chambre --</option>
                                                                <?php foreach ($chambres as $ch): ?>
                                                                    <option value="<?= htmlspecialchars($ch['numero_chambre']) ?>" data-price="<?= $ch['prix_journalier'] ?>" <?= $ch['numero_chambre'] == $reservation['numero_chambre'] ? 'selected' : '' ?>>
                                                                        Chambre <?= htmlspecialchars($ch['numero_chambre']) ?> - <?= number_format($ch['prix_journalier'], 2, ',', ' ') ?>€/jour
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="date_debut" class="form-label">Date de début</label>
                                                            <input type="date" class="form-control date-input" id="date_debut_<?= $reservation['id'] ?>" name="date_debut" value="<?= $reservation['date_debut'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="date_fin" class="form-label">Date de fin</label>
                                                            <input type="date" class="form-control date-input" id="date_fin_<?= $reservation['id'] ?>" name="date_fin" value="<?= $reservation['date_fin'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nb_personne" class="form-label">Nombre de personnes</label>
                                                            <input type="number" class="form-control" name="nb_personne" value="<?= $reservation['nb_personne'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="prix" class="form-label">Prix total (€)</label>
                                                            <input type="number" class="form-control price-input" id="prix_<?= $reservation['id'] ?>" name="prix" step="0.01" value="<?= $reservation['prix'] ?>" required>
                                                            <small class="text-muted">Calculé automatiquement en fonction du nombre de jours et du tarif de la chambre</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
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
                        <h5>Aucune réservation</h5>
                        <p>Il n'y a actuellement aucune réservation dans le système.</p>
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

    <script>
        // Fonction pour calculer le prix automatiquement
        function calculatePrice(reservationId) {
            const chambreSelect = document.querySelector(`#num_chambre_${reservationId}`);
            const dateDebut = document.querySelector(`#date_debut_${reservationId}`);
            const dateFin = document.querySelector(`#date_fin_${reservationId}`);
            const priceInput = document.querySelector(`#prix_${reservationId}`);

            if (chambreSelect.value && dateDebut.value && dateFin.value) {
                const startDate = new Date(dateDebut.value);
                const endDate = new Date(dateFin.value);

                // Calculer le nombre de jours
                const timeDiff = endDate.getTime() - startDate.getTime();
                const days = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (days > 0) {
                    const selectedOption = chambreSelect.options[chambreSelect.selectedIndex];
                    const pricePerDay = parseFloat(selectedOption.getAttribute('data-price'));
                    const totalPrice = days * pricePerDay;
                    priceInput.value = totalPrice.toFixed(2);
                }
            }
        }

        // Ajouter les event listeners pour chaque modal
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer tous les modales d'édition
            const modals = document.querySelectorAll('[id^="quickEditModal"]');

            modals.forEach(modal => {
                const reservationId = modal.id.replace('quickEditModal', '');
                const chambreSelect = document.querySelector(`#chambre_id_${reservationId}`);
                const dateDebut = document.querySelector(`#date_debut_${reservationId}`);
                const dateFin = document.querySelector(`#date_fin_${reservationId}`);

                if (chambreSelect && dateDebut && dateFin) {
                    chambreSelect.addEventListener('change', () => calculatePrice(reservationId));
                    dateDebut.addEventListener('change', () => calculatePrice(reservationId));
                    dateFin.addEventListener('change', () => calculatePrice(reservationId));
                }
            });
        });
    </script>
</body>

</html>