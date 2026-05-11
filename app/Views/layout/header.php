<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'ProjetRegime' ?></title>
    <link href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('<?= base_url('images/background.jpg') ?>');
            background-size: 150%;
            background-attachment: fixed;
            background-position: center;
        }
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand img {
            height: 60px;
            max-width: 60px;
            object-fit: contain;
        }
        footer {
            background: linear-gradient(135deg, #2A3F5F, #1E3049);
            border-top: 1px solid #1a2a3a;
            padding: 2rem 0;
            margin-top: auto;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-lg">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
                <img src="<?= base_url('images/logo.svg') ?>" alt="Logo">
                <span class="fw-bold">ProjetRegime</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (session()->get('user_id')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('dashboard') ?>">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('objectif/choisir') ?>">Objectifs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('wallet') ?>">Portefeuille</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('profil/modifier') ?>">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">Déconnexion</a>
                        </li>
                    <?php elseif (session()->get('admin_id')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/regimes') ?>">Régimes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/activites') ?>">Activités</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/codes') ?>">Codes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('register') ?>">S'inscrire</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1">
