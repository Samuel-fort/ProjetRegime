<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title><?= $activite ? 'Modifier' : 'Créer' ?> une activité</title></head>
<body>

<h1><?= $activite ? 'Modifier l\'activité' : 'Nouvelle activité' ?></h1>
<a href="<?= base_url('admin/activites') ?>">← Retour</a>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="<?= $activite ? base_url('admin/activites/update/' . $activite['id']) : base_url('admin/activites/store') ?>" method="post">
    <?= csrf_field() ?>

    <div>
        <label>Nom</label><br>
        <input type="text" name="nom" value="<?= esc($activite['nom'] ?? '') ?>" required>
    </div>

    <div>
        <label>Description</label><br>
        <textarea name="description"><?= esc($activite['description'] ?? '') ?></textarea>
    </div>

    <div>
        <label>Durée (minutes)</label><br>
        <input type="number" name="duree_minutes" value="<?= $activite['duree_minutes'] ?? '' ?>" required>
    </div>

    <div>
        <label>Calories par heure</label><br>
        <input type="number" name="calories_heure" value="<?= $activite['calories_heure'] ?? '' ?>" required>
    </div>

    <div>
        <label>Objectif</label><br>
        <select name="objectif" required>
            <option value="">-- Choisir --</option>
            <?php foreach (['augmenter', 'reduire', 'imc_ideal'] as $obj): ?>
                <option value="<?= $obj ?>" <?= ($activite['objectif'] ?? '') === $obj ? 'selected' : '' ?>>
                    <?= $obj ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label>
            <input type="checkbox" name="actif" value="1" <?= ($activite['actif'] ?? 1) ? 'checked' : '' ?>>
            Actif
        </label>
    </div>

    <div>
        <button type="submit"><?= $activite ? 'Modifier' : 'Créer' ?></button>
    </div>

</form>

</body>
</html>