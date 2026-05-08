<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Étape 2</title>
</head>
<body>

<h2>Créer un compte – Étape 2 / 2</h2>
<p>Informations physiques</p>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="/register/step2" method="post">
    <?= csrf_field() ?>

    <div>
        <label for="taille">Taille (cm)</label><br>
        <input type="number" id="taille" name="taille" min="50" max="250" step="0.1"
               value="<?= esc($old['taille'] ?? '') ?>" required>
    </div>

    <div>
        <label for="poids">Poids (kg)</label><br>
        <input type="number" id="poids" name="poids" min="10" max="300" step="0.1"
               value="<?= esc($old['poids'] ?? '') ?>" required>
    </div>

    <div>
        <button type="button" onclick="window.history.back()">← Retour</button>
        <button type="submit">Créer mon compte</button>
    </div>

</form>

</body>
</html>