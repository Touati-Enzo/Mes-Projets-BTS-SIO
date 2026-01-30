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
                    <a class="nav-link <?= (current_url() == base_url('/') ? 'active' : '') ?>" href="<?= base_url('/') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                        <i class="fas fa-home me-2"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(current_url(), '/chambres') !== false ? 'active' : '') ?>" href="<?= base_url('/chambres') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                        <i class="fas fa-door-open me-2"></i>Chambres
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(current_url(), '/reservations') !== false ? 'active' : '') ?>" href="<?= base_url('/reservations') ?>" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500; transition: all 0.3s;">
                        <i class="fas fa-calendar me-2"></i>Réservations
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" style="color: rgba(255, 255, 255, 0.8) !important; font-weight: 500;">
                        <i class="fas fa-user me-2"></i><?= isset($user) ? $user['username'] : session()->get('username') ?>
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

<style>
    .nav-link:hover,
    .nav-link.active {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
    }
</style>