<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - ProjetCVVEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">ProjetCVVEN</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Connecté en tant que: <?= $user['username'] ?>
                </span>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Menu
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item active">Tableau de bord</li>
                        <li class="list-group-item">Mon profil</li>
                        <li class="list-group-item">Paramètres</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Bienvenue sur votre tableau de bord</h5>
                    </div>
                    <div class="card-body">
                        <h4>Bonjour, <?= $user['username'] ?> !</h4>
                        <p>Vous êtes connecté avec l'email: <?= $user['email'] ?></p>
                        <p>Rôle: <?= $user['role'] ?></p>

                        <div class="alert alert-info">
                            Ceci est votre page d'accueil sécurisée. Vous pouvez maintenant développer
                            les fonctionnalités spécifiques à votre projet ProjetCVVEN.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>