<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4"><?= $activite ? 'Modifier l\'activité' : 'Nouvelle activité' ?></h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= esc($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= $activite ? base_url('admin/activites/update/' . $activite['id']) : base_url('admin/activites/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= esc($activite['nom'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= esc($activite['description'] ?? '') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="objectif" class="form-label">Objectif</label>
                        <select class="form-select" id="objectif" name="objectif" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="augmenter" <?= (($activite['objectif'] ?? '') === 'augmenter') ? 'selected' : '' ?>>Augmenter poids</option>
                            <option value="reduire" <?= (($activite['objectif'] ?? '') === 'reduire') ? 'selected' : '' ?>>Réduire poids</option>
                            <option value="imc_ideal" <?= (($activite['objectif'] ?? '') === 'imc_ideal') ? 'selected' : '' ?>>IMC idéal</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="duree_minutes" class="form-label">Durée (minutes)</label>
                        <input type="number" min="1" class="form-control" id="duree_minutes" name="duree_minutes" value="<?= esc($activite['duree_minutes'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="calories_heure" class="form-label">Calories/heure</label>
                    <input type="number" min="1" class="form-control" id="calories_heure" name="calories_heure" value="<?= esc($activite['calories_heure'] ?? '') ?>" required>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="actif" name="actif" value="1" <?= (!empty($activite['actif'])) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="actif">Activité active</label>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= base_url('admin/activites') ?>" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary"><?= $activite ? 'Modifier' : 'Créer' ?> l'activité</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo view('layout/footer'); ?>