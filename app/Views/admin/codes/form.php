<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="mb-4">Nouveau code wallet</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= esc($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/codes/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" class="form-control" id="code" name="code" placeholder="ex: PROMO-ABC123" required>
                </div>

                <div class="mb-3">
                    <label for="montant" class="form-label">Montant (Ar)</label>
                    <input type="number" class="form-control" id="montant" name="montant" min="1" step="0.01" required>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= base_url('admin/codes') ?>" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Créer le code</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo view('layout/footer'); ?>