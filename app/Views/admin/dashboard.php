<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>

<h1>Tableau de bord Admin</h1>
<p>Bienvenue, <?= esc(session()->get('admin_email')) ?></p>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<ul>
    <li>Régimes : <strong><?= $nb_regimes ?></strong></li>
    <li>Activités : <strong><?= $nb_activites ?></strong></li>
    <li>Codes wallet : <strong><?= $nb_codes ?></strong> (<?= $nb_codes_used ?> utilisés)</li>
</ul>

<nav>
    <a href="<?= base_url('/admin/regimes') ?>">Gérer les régimes</a> |
    <a href="<?= base_url('/admin/activites') ?>">Gérer les activités</a> |
    <a href="<?= base_url('/admin/codes') ?>">Gérer les codes wallet</a> |
    <a href="<?= base_url('/logout') ?>">Se déconnecter</a>
</nav>

</body>
</html>