<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <?php
    $objectif = $objectif ?? '';
    $regimes = $regimes ?? [];
    $activites = $activites ?? [];
    ?>

    <h1 class="mb-4">Suggestions pour "<?= esc((string) $objectif) ?>"</h1>
    <p class="mb-4"><a href="<?= base_url('objectif/suggestions/pdf') ?>" target="_blank" class="btn btn-sm btn-outline-secondary">Exporter en PDF</a></p>

    <h2 class="mt-5 mb-4">Régimes suggérés</h2>
    <?php if (empty($regimes)): ?>
        <div class="alert alert-info">Aucun régime trouvé pour cet objectif.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($regimes as $r): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc((string) ($r['nom'] ?? '')) ?></h5>
                            <p class="card-text"><?= esc((string) ($r['description'] ?? '')) ?></p>
                            <p class="mb-2"><strong>Prix :</strong> <?= isset($r['prix_min']) ? number_format((float) $r['prix_min'], 2, ',', ' ') : 'N/A' ?> €</p>
                            <p class="mb-2"><strong>Variation :</strong> <?= esc((string) ($r['variation_poids'] ?? '')) ?> kg</p>
                            <p class="text-muted small">Viande: <?= esc((string) ($r['pct_viande'] ?? '')) ?> • Poisson: <?= esc((string) ($r['pct_poisson'] ?? '')) ?> • Volaille: <?= esc((string) ($r['pct_volaille'] ?? '')) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h2 class="mt-5 mb-4">Activités sportives suggérées</h2>
    <?php if (empty($activites)): ?>
        <div class="alert alert-info">Aucune activité trouvée pour cet objectif.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($activites as $a): ?>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title"><?= esc((string) ($a['nom'] ?? '')) ?></h6>
                            <p class="card-text small"><?= esc((string) ($a['description'] ?? '')) ?></p>
                            <p class="text-muted small mb-0"><?= esc((string) ($a['duree_minutes'] ?? '')) ?> min • <?= esc((string) ($a['calories_heure'] ?? '')) ?> kcal/h</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mt-5">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Retour au dashboard</a>
    </div>
</div>
<?php echo view('layout/footer'); ?>
