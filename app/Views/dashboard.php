<?php
$session = session();
$user_id = $session->get('user_id');
$user_nom = $session->get('user_nom');
$is_gold = $session->get('is_gold');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Mon Régime</title>
</head>
<body>
<nav>
    <span>Mon Régime</span>
    <div>
        <?php if($is_gold): ?>
            <span>Membre Gold</span>
        <?php endif; ?>
        <a href="<?= base_url('logout') ?>">Déconnexion</a>
    </div>
</nav>

<div class="container">
    <h1>Bienvenue, <?= htmlspecialchars($user_nom) ?></h1>
    <p>Gérez votre régime et votre portefeuille</p>

    <div class="section">
        <h2>Régimes</h2>
        <p>Découvrez et achetez nos régimes personnalisés</p>
        <a href="#">Voir les régimes</a>
    </div>

    <div class="section">
        <h2>Activités Sportives</h2>
        <p>Trouvez les meilleures activités pour votre objectif</p>
        <a href="#">Voir les activités</a>
    </div>

    <div class="section">
        <h2>Portefeuille</h2>
        <p>Gérez votre solde et validez des codes</p>
        <a href="<?= base_url('wallet/test') ?>">Accéder au portefeuille</a>
    </div>

    <div class="section">
        <h2>Mes Commandes</h2>
        <p>Consultez l'historique de vos achats</p>
        <a href="#">Voir les commandes</a>
    </div>
</div>

</body>
</html>
