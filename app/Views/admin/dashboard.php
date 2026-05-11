<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <h1 class="mb-4">Tableau de bord Admin</h1>
    <p class="text-muted mb-4">Bienvenue, <?= esc(session()->get('admin_email')) ?></p>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title">Régimes</h6>
                    <p class="display-4 text-primary"><?= $nb_regimes ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title">Activités</h6>
                    <p class="display-4 text-success"><?= $nb_activites ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title">Codes Wallet</h6>
                    <p class="display-4 text-info"><?= $nb_codes ?></p>
                    <p class="text-muted small mb-0"><?= $nb_codes_used ?> utilisés</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4>Liens de gestion</h4>
        <a href="<?= base_url('/admin/regimes') ?>" class="btn btn-outline-primary me-2 mb-2">Gérer les régimes</a>
        <a href="<?= base_url('/admin/activites') ?>" class="btn btn-outline-success me-2 mb-2">Gérer les activités</a>
        <a href="<?= base_url('/admin/codes') ?>" class="btn btn-outline-info mb-2">Gérer les codes wallet</a>
    </div>
</div>
<?php echo view('layout/footer'); ?>
</html>