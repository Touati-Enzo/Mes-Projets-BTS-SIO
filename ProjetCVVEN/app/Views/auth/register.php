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

        .register-container {
            max-width: 500px;
            width: 100%;
        }

        .register-card {
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

        .btn-register {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        .login-link {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 2px;
            transition: all 0.3s;
        }

        .strength-weak {
            background-color: #dc3545;
            width: 25%;
        }

        .strength-medium {
            background-color: #ffc107;
            width: 50%;
        }

        .strength-strong {
            background-color: #28a745;
            width: 75%;
        }

        .strength-very-strong {
            background-color: #28a745;
            width: 100%;
        }

        .terms-text {
            font-size: 0.9rem;
            color: #666;
        }

        .error-message {
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .logo {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .subtitle {
            opacity: 0.9;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="register-container mx-auto">
                    <div class="register-card card">
                        <div class="card-header">
                            <div class="logo">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h2 class="mb-2">Créer un compte</h2>
                            <p class="subtitle mb-0">Rejoignez ProjetCVVEN dès maintenant</p>
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

                            <form action="<?= base_url('auth/register') ?>" method="post" id="registerForm">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <!-- Nom -->
                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">
                                            <i class="fas fa-user me-1"></i>Nom *
                                        </label>
                                        <input type="text"
                                            class="form-control <?= session()->getFlashdata('error_last_name') ? 'is-invalid' : '' ?>"
                                            id="last_name"
                                            name="last_name"
                                            value="<?= old('last_name') ?>"
                                            placeholder="Votre nom"
                                            required>
                                        <?php if (session()->getFlashdata('error_last_name')): ?>
                                            <div class="invalid-feedback">
                                                <?= session()->getFlashdata('error_last_name') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Prénom -->
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label">
                                            <i class="fas fa-user me-1"></i>Prénom *
                                        </label>
                                        <input type="text"
                                            class="form-control <?= session()->getFlashdata('error_first_name') ? 'is-invalid' : '' ?>"
                                            id="first_name"
                                            name="first_name"
                                            value="<?= old('first_name') ?>"
                                            placeholder="Votre prénom"
                                            required>
                                        <?php if (session()->getFlashdata('error_first_name')): ?>
                                            <div class="invalid-feedback">
                                                <?= session()->getFlashdata('error_first_name') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>Adresse email *
                                    </label>
                                    <input type="email"
                                        class="form-control <?= session()->getFlashdata('error_email') ? 'is-invalid' : '' ?>"
                                        id="email"
                                        name="email"
                                        value="<?= old('email') ?>"
                                        placeholder="exemple@email.com"
                                        required>
                                    <?php if (session()->getFlashdata('error_email')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('error_email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Nom d'utilisateur -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">
                                        <i class="fas fa-at me-1"></i>Nom d'utilisateur *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text"
                                            class="form-control <?= session()->getFlashdata('error_username') ? 'is-invalid' : '' ?>"
                                            id="username"
                                            name="username"
                                            value="<?= old('username') ?>"
                                            placeholder="choisissez un nom d'utilisateur"
                                            required>
                                    </div>
                                    <small class="text-muted">Entre 3 et 20 caractères</small>
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
                                            placeholder="Minimum 6 caractères"
                                            required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="password-strength" id="passwordStrength"></div>
                                    <small class="text-muted">Force du mot de passe : <span id="strengthText">Faible</span></small>
                                    <?php if (session()->getFlashdata('error_password')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= session()->getFlashdata('error_password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Confirmation mot de passe -->
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>Confirmer le mot de passe *
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control <?= session()->getFlashdata('error_confirm_password') ? 'is-invalid' : '' ?>"
                                            id="confirm_password"
                                            name="confirm_password"
                                            placeholder="Retapez votre mot de passe"
                                            required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="error-message text-danger" id="passwordMatchError"></div>
                                    <?php if (session()->getFlashdata('error_confirm_password')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= session()->getFlashdata('error_confirm_password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Conditions d'utilisation -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input <?= session()->getFlashdata('error_terms') ? 'is-invalid' : '' ?>"
                                            type="checkbox"
                                            id="terms"
                                            name="terms"
                                            <?= old('terms') ? 'checked' : '' ?>
                                            required>
                                        <label class="form-check-label terms-text" for="terms">
                                            J'accepte les <a href="#" class="login-link">conditions d'utilisation</a>
                                            et la <a href="#" class="login-link">politique de confidentialité</a> *
                                        </label>
                                    </div>
                                    <?php if (session()->getFlashdata('error_terms')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= session()->getFlashdata('error_terms') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Bouton d'inscription -->
                                <div class="d-grid gap-2 mb-3">
                                    <button type="submit" class="btn btn-register btn-lg text-white" id="submitBtn">
                                        <i class="fas fa-user-plus me-2"></i>S'inscrire
                                    </button>
                                </div>

                                <!-- Lien vers connexion -->
                                <div class="text-center">
                                    <p class="mb-0">
                                        Déjà un compte ?
                                        <a href="<?= base_url('login') ?>" class="login-link">
                                            <i class="fas fa-sign-in-alt me-1"></i>Se connecter
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
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });

            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });

            // Password strength checker
            password.addEventListener('input', function() {
                checkPasswordStrength(this.value);
                checkPasswordMatch();
            });

            confirmPassword.addEventListener('input', checkPasswordMatch);

            // Check password strength
            function checkPasswordStrength(password) {
                let strength = 0;
                const strengthBar = document.getElementById('passwordStrength');
                const strengthText = document.getElementById('strengthText');

                if (password.length >= 6) strength++;
                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;

                // Reset classes
                strengthBar.className = 'password-strength';

                if (password.length === 0) {
                    strengthBar.className = 'password-strength';
                    strengthText.textContent = 'Faible';
                } else if (strength < 2) {
                    strengthBar.className = 'password-strength strength-weak';
                    strengthText.textContent = 'Faible';
                } else if (strength < 4) {
                    strengthBar.className = 'password-strength strength-medium';
                    strengthText.textContent = 'Moyen';
                } else if (strength < 5) {
                    strengthBar.className = 'password-strength strength-strong';
                    strengthText.textContent = 'Fort';
                } else {
                    strengthBar.className = 'password-strength strength-very-strong';
                    strengthText.textContent = 'Très fort';
                }
            }

            // Check if passwords match
            function checkPasswordMatch() {
                const passwordValue = password.value;
                const confirmValue = confirmPassword.value;
                const errorElement = document.getElementById('passwordMatchError');
                const submitBtn = document.getElementById('submitBtn');

                if (confirmValue.length === 0) {
                    errorElement.textContent = '';
                    submitBtn.disabled = false;
                } else if (passwordValue !== confirmValue) {
                    errorElement.textContent = 'Les mots de passe ne correspondent pas';
                    submitBtn.disabled = true;
                } else {
                    errorElement.textContent = '';
                    submitBtn.disabled = false;
                }
            }

            // Auto-check form on load if there are old values
            if (password.value) {
                checkPasswordStrength(password.value);
            }
            checkPasswordMatch();

            // Form validation before submit
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const passwordValue = password.value;
                const confirmValue = confirmPassword.value;

                if (passwordValue !== confirmValue) {
                    e.preventDefault();
                    alert('Les mots de passe ne correspondent pas !');
                    return false;
                }

                if (passwordValue.length < 6) {
                    e.preventDefault();
                    alert('Le mot de passe doit contenir au moins 6 caractères');
                    return false;
                }

                if (!document.getElementById('terms').checked) {
                    e.preventDefault();
                    alert('Vous devez accepter les conditions d\'utilisation');
                    return false;
                }

                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Inscription en cours...';
                submitBtn.disabled = true;
            });

            // Real-time username availability check (simplified)
            const usernameInput = document.getElementById('username');
            let usernameTimeout;

            usernameInput.addEventListener('input', function() {
                clearTimeout(usernameTimeout);
                usernameTimeout = setTimeout(checkUsernameAvailability, 500);
            });

            function checkUsernameAvailability() {
                const username = usernameInput.value.trim();
                if (username.length >= 3) {
                    // In a real app, you would make an AJAX call here
                    console.log('Checking username:', username);
                }
            }
        });
    </script>
</body>

</html>