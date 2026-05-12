<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php
            $prix_gold = $prix_gold ?? '90000';
            $taux_remise_gold = $taux_remise_gold ?? '15';
            ?>
            <h1 class="mb-4">Paramètres globaux</h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= esc((string) session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= esc((string) session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('admin/parametres') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="prix_gold" class="form-label">Prix Gold</label>
                    <input type="number" min="0" step="0.01" class="form-control" id="prix_gold" name="prix_gold" value="<?= esc((string) $prix_gold) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="taux_remise_gold" class="form-label">Remise Gold (%)</label>
                    <input type="number" min="0" max="100" step="0.01" class="form-control" id="taux_remise_gold" name="taux_remise_gold" value="<?= esc((string) $taux_remise_gold) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Retour</a>
            </form>
        </div>
    </div>
</div>
<?php echo view('layout/footer'); ?>