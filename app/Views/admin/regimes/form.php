<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title><?= $regime ? 'Modifier' : 'Créer' ?> un régime</title></head>
<body>

<h1><?= $regime ? 'Modifier le régime' : 'Nouveau régime' ?></h1>
<a href="<?= base_url('admin/regimes') ?>">← Retour</a>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="<?= $regime ? base_url('admin/regimes/update/' . $regime['id']) : base_url('admin/regimes/store') ?>" method="post">
    <?= csrf_field() ?>

    <div>
        <label>Nom</label><br>
        <input type="text" name="nom" value="<?= esc($regime['nom'] ?? '') ?>" required>
    </div>

    <div>
        <label>Description</label><br>
        <textarea name="description"><?= esc($regime['description'] ?? '') ?></textarea>
    </div>

    <div>
        <label>Objectif</label><br>
        <select name="objectif" required>
            <option value="">-- Choisir --</option>
            <?php foreach (['augmenter', 'reduire', 'imc_ideal'] as $obj): ?>
                <option value="<?= $obj ?>" <?= ($regime['objectif'] ?? '') === $obj ? 'selected' : '' ?>>
                    <?= $obj ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label>Variation poids (kg)</label><br>
        <input type="number" step="0.1" name="variation_poids" value="<?= $regime['variation_poids'] ?? 0 ?>">
    </div>

    <div>
        <label>% Viande</label><br>
        <input type="number" name="pct_viande" min="0" max="100" value="<?= $regime['pct_viande'] ?? 0 ?>">
    </div>

    <div>
        <label>% Poisson</label><br>
        <input type="number" name="pct_poisson" min="0" max="100" value="<?= $regime['pct_poisson'] ?? 0 ?>">
    </div>

    <div>
        <label>% Volaille</label><br>
        <input type="number" name="pct_volaille" min="0" max="100" value="<?= $regime['pct_volaille'] ?? 0 ?>">
    </div>

    <div>
        <label>Prix 30 jours</label><br>
        <input type="number" name="prix_30" value="<?= $prix[30] ?? '' ?>">
    </div>

    <div>
        <label>Prix 60 jours</label><br>
        <input type="number" name="prix_60" value="<?= $prix[60] ?? '' ?>">
    </div>

    <div>
        <label>Prix 90 jours</label><br>
        <input type="number" name="prix_90" value="<?= $prix[90] ?? '' ?>">
    </div>

    <div>
        <label>
            <input type="checkbox" name="actif" value="1" <?= ($regime['actif'] ?? 1) ? 'checked' : '' ?>>
            Actif
        </label>
    </div>

    <div>
        <button type="submit"><?= $regime ? 'Modifier' : 'Créer' ?></button>
    </div>

</form>

</body>
</html>