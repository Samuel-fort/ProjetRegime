<?php echo view('layout/header'); ?>
<?php
// Défauts pour éviter les erreurs si la vue est incluse sans données
if (! isset($regime) || ! is_array($regime)) {
    $regime = null;
}

if (! isset($prix) || ! is_array($prix)) {
    $prix = [];
}

if (! isset($errors) || ! is_array($errors)) {
    $errors = [];
}

$regimeData = is_array($regime) ? $regime : [];
?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4"><?= ! empty($regimeData) ? 'Modifier le régime' : 'Nouveau régime' ?></h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= esc((string) $e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= ! empty($regimeData) ? base_url('admin/regimes/update/' . ($regimeData['id'] ?? '')) : base_url('admin/regimes/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= esc((string) ($regimeData['nom'] ?? '')) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= esc((string) ($regimeData['description'] ?? '')) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="objectif" class="form-label">Objectif</label>
                        <select class="form-select" id="objectif" name="objectif" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="augmenter" <?= (($regimeData['objectif'] ?? '') === 'augmenter') ? 'selected' : '' ?>>Augmenter poids</option>
                            <option value="reduire" <?= (($regimeData['objectif'] ?? '') === 'reduire') ? 'selected' : '' ?>>Réduire poids</option>
                            <option value="imc_ideal" <?= (($regimeData['objectif'] ?? '') === 'imc_ideal') ? 'selected' : '' ?>>IMC idéal</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="variation_poids" class="form-label">Variation poids (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="variation_poids" name="variation_poids" value="<?= esc((string) ($regimeData['variation_poids'] ?? '')) ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="pct_viande" class="form-label">% Viande</label>
                        <input type="number" min="0" max="100" class="form-control" id="pct_viande" name="pct_viande" value="<?= esc((string) ($regimeData['pct_viande'] ?? '0')) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pct_poisson" class="form-label">% Poisson</label>
                        <input type="number" min="0" max="100" class="form-control" id="pct_poisson" name="pct_poisson" value="<?= esc((string) ($regimeData['pct_poisson'] ?? '0')) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pct_volaille" class="form-label">% Volaille</label>
                        <input type="number" min="0" max="100" class="form-control" id="pct_volaille" name="pct_volaille" value="<?= esc((string) ($regimeData['pct_volaille'] ?? '0')) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="prix_30" class="form-label">Prix (30 jours)</label>
                        <input type="number" min="0" step="0.01" class="form-control" id="prix_30" name="prix_30" value="<?= esc($prix[30] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="prix_60" class="form-label">Prix (60 jours)</label>
                        <input type="number" min="0" step="0.01" class="form-control" id="prix_60" name="prix_60" value="<?= esc($prix[60] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="prix_90" class="form-label">Prix (90 jours)</label>
                        <input type="number" min="0" step="0.01" class="form-control" id="prix_90" name="prix_90" value="<?= esc($prix[90] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="actif" name="actif" value="1" <?= (! empty($regimeData['actif'])) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="actif">Actif</label>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= base_url('admin/regimes') ?>" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary"><?= $regime ? 'Modifier' : 'Créer' ?> le régime</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo view('layout/footer'); ?>