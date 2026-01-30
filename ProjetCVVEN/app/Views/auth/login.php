<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - ProjetCVVEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0066cc 0%, #00b4d8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #0066cc 0%, #00b4d8 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .card-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #0066cc;
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }

        .btn-login {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .register-link {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .logo {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .subtitle {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-check-input:checked {
            background-color: #ff6b35;
            border-color: #ff6b35;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="login-container mx-auto">
                    <div class="login-card card">
                        <div class="card-header">
                            <div class="logo">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <h2 class="mb-2">Connexion</h2>
                            <p class="subtitle mb-0">Accédez à votre compte ProjetCVVEN</p>
                        </div>

                        <div class="card-body">
                            <!-- Messages de succès -->
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <!-- Messages d'erreur généraux -->
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <!-- Messages de validation -->
                            <?php if (session()->getFlashdata('errors')): ?>
                                <div class="alert alert-danger">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Veuillez corriger les erreurs suivantes :</h6>
                                    <ul class="mb-0">
                                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                            <li><?= $error ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('auth/login') ?>" method="post" id="loginForm">
                                <?= csrf_field() ?>

                                <!-- Email ou Nom d'utilisateur -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">
                                        <i class="fas fa-user me-1"></i>Email ou Nom d'utilisateur *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-at"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control <?= session()->getFlashdata('error_username') ? 'is-invalid' : '' ?>"
                                            id="username"
                                            name="username"
                                            value="<?= old('username') ?>"
                                            placeholder="votre@email.com ou votre nom d'utilisateur"
                                            required>
                                    </div>
                                    <?php if (session()->getFlashdata('error_username')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= session()->getFlashdata('error_username') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Mot de passe -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>Mot de passe *
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control <?= session()->getFlashdata('error_password') ? 'is-invalid' : '' ?>"
                                            id="password"
                                            name="password"
                                            placeholder="Votre mot de passe"
                                            required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <?php if (session()->getFlashdata('error_password')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= session()->getFlashdata('error_password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Se souvenir de moi et Mot de passe oublié -->
                                <div class="remember-forgot">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            id="remember"
                                            name="remember"
                                            <?= old('remember') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="remember">
                                            Se souvenir de moi
                                        </label>
                                    </div>
                                    <div>
                                        <a href="<?= base_url('auth/forgot-password') ?>" class="register-link">
                                            <i class="fas fa-key me-1"></i>Mot de passe oublié ?
                                        </a>
                                    </div>
                                </div>

                                <!-- Bouton de connexion -->
                                <div class="d-grid gap-2 mb-3">
                                    <button type="submit" class="btn btn-login btn-lg text-white" id="submitBtn">
                                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                    </button>
                                </div>

                                <!-- Lien vers inscription -->
                                <div class="text-center">
                                    <p class="mb-0">
                                        Pas encore de compte ?
                                        <a href="<?= base_url('auth/register') ?>" class="register-link">
                                            <i class="fas fa-user-plus me-1"></i>S'inscrire
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>

                        <div class="card-footer text-center py-3">
                            <small class="text-muted">
                                &copy; <?= date('Y') ?> ProjetCVVEN. Tous droits réservés.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });

            // Form validation and loading state
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const username = document.getElementById('username').value.trim();
                const passwordValue = password.value;

                if (!username) {
                    e.preventDefault();
                    alert('Veuillez saisir votre email ou nom d\'utilisateur');
                    return false;
                }

                if (!passwordValue) {
                    e.preventDefault();
                    alert('Veuillez saisir votre mot de passe');
                    return false;
                }

                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Connexion en cours...';
                submitBtn.disabled = true;
            });

            // Auto-focus on username field
            document.getElementById('username').focus();

            // Enter key submits form
            document.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.target.matches('textarea')) {
                    const activeElement = document.activeElement;
                    if (activeElement && (activeElement.tagName === 'INPUT' || activeElement.tagName === 'BUTTON')) {
                        return; // Let the default behavior for inputs and buttons
                    }
                }
            });
        });
    </script>
</body>

</html>