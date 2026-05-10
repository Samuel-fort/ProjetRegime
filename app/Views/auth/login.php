<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="<?= base_url('login') ?>" method="post">
    <?= csrf_field() ?>

    <div>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" required>
    </div>

    <div>
        <label for="mot_de_passe">Mot de passe</label><br>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
    </div>

    <div>
        <button type="submit">Se connecter</button>
    </div>

</form>

<p>Pas encore de compte ? <a href="<?= base_url('/register') ?>">S'inscrire</a></p>

</body>
</html>