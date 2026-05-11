<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4"><?= $regime ? 'Modifier le régime' : 'Nouveau régime' ?></h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= esc($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= $regime ? base_url('admin/regimes/update/' . $regime['id']) : base_url('admin/regimes/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= esc($regime['nom'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= esc($regime['description'] ?? '') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="objectif" class="form-label">Objectif</label>
                        <select class="form-select" id="objectif" name="objectif" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="augmenter" <?= (($regime['objectif'] ?? '') === 'augmenter') ? 'selected' : '' ?>>Augmenter poids</option>
                            <option value="reduire" <?= (($regime['objectif'] ?? '') === 'reduire') ? 'selected' : '' ?>>Réduire poids</option>
                            <option value="imc_ideal" <?= (($regime['objectif'] ?? '') === 'imc_ideal') ? 'selected' : '' ?>>IMC idéal</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="variation_poids" class="form-label">Variation poids (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="variation_poids" name="variation_poids" value="<?= esc($regime['variation_poids'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="pct_viande" class="form-label">% Viande</label>
                        <input type="number" min="0" max="100" class="form-control" id="pct_viande" name="pct_viande" value="<?= esc($regime['pct_viande'] ?? '0') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pct_poisson" class="form-label">% Poisson</label>
                        <input type="number" min="0" max="100" class="form-control" id="pct_poisson" name="pct_poisson" value="<?= esc($regime['pct_poisson'] ?? '0') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pct_volaille" class="form-label">% Volaille</label>
                        <input type="number" min="0" max="100" class="form-control" id="pct_volaille" name="pct_volaille" value="<?= esc($regime['pct_volaille'] ?? '0') ?>">
                    </div>
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