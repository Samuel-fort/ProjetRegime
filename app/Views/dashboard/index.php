<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <?php
    $user = $user ?? [];
    $imc = $imc ?? 0;
    $categorie = $categorie ?? '';
    $progression = $progression ?? 0;
    $walletLabel = $walletLabel ?? 'Ar';
    ?>

    <h1 class="mb-4">Bienvenue, <?= esc($user['nom'] ?? '') ?></h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profil</h5>
                    <p><strong>Nom :</strong> <?= esc((string) ($user['nom'] ?? '')) ?></p>
                    <p><strong>Email :</strong> <?= esc((string) ($user['email'] ?? '')) ?></p>
                    <p><strong>Genre :</strong> <?= esc((string) ($user['genre'] ?? '')) ?></p>
                    <p class="mb-0"><strong>Taille :</strong> <?= esc((string) ($user['taille'] ?? '')) ?> cm</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">IMC</h5>
                    <p><strong>Valeur :</strong> <?= number_format((float) $imc, 2, ',', ' ') ?></p>
                    <p><strong>Catégorie :</strong> <?= esc($categorie) ?></p>
                    <div class="progress">
                        <div class="progress-bar" style="width:<?= esc((string) $progression) ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Portefeuille</h5>
                    <p class="display-6 text-primary mb-0"><?= esc(number_format((float) ($user['wallet'] ?? 0), 2, ',', ' ')) ?> <?= esc($walletLabel) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statut</h5>
                    <p><span class="badge bg-<?= ! empty($user['is_gold']) ? 'warning' : 'secondary' ?>"><?= ! empty($user['is_gold']) ? 'Membre Gold ✓' : 'Standard' ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="mb-3">Actions rapides</h4>
        <a href="<?= base_url('profil/modifier') ?>" class="btn btn-outline-primary me-2 mb-2">Modifier le profil</a>
        <a href="<?= base_url('objectif/choisir') ?>" class="btn btn-outline-primary me-2 mb-2">Choisir un objectif</a>
        <a href="<?= base_url('wallet') ?>" class="btn btn-outline-primary mb-2">Gérer portefeuille</a>
    </div>
</div>
<?php echo view('layout/footer'); ?>
