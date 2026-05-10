<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Étape 1</title>
</head>
<body>

<h2>Créer un compte – Étape 1 / 2</h2>
<p>Informations personnelles</p>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="<?= base_url('register/step1') ?>" method="post">
    <?= csrf_field() ?>

    <div>
        <label for="nom">Nom complet</label><br>
        <input type="text" id="nom" name="nom"
               value="<?= esc($old['nom'] ?? '') ?>" required>
    </div>

    <div>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email"
               value="<?= esc($old['email'] ?? '') ?>" required>
    </div>

    <div>
        <label for="mot_de_passe">Mot de passe</label><br>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
    </div>

    <div>
        <label for="mot_de_passe_confirm">Confirmer le mot de passe</label><br>
        <input type="password" id="mot_de_passe_confirm" name="mot_de_passe_confirm" required>
    </div>

    <div>
        <label>Genre</label><br>
        <label>
            <input type="radio" name="genre" value="homme"
                <?= (($old['genre'] ?? '') === 'homme') ? 'checked' : '' ?>>
            Homme
        </label>
        <label>
            <input type="radio" name="genre" value="femme"
                <?= (($old['genre'] ?? '') === 'femme') ? 'checked' : '' ?>>
            Femme
        </label>
    </div>

    <div>
        <button type="submit">Suivant →</button>
    </div>

</form>

<p>Déjà un compte ? <a href="<?= base_url('/') ?>">Se connecter</a></p>

</body>
</html>