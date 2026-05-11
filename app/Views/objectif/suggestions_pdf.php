<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suggestions - <?= esc((string) ($objectif ?? '')) ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2 { margin-bottom: 8px; }
        .card { border: 1px solid #999; padding: 8px; margin-bottom: 8px; }
    </style>
</head>
<body>
    <?php
    $objectif = $objectif ?? '';
    $regimes = $regimes ?? [];
    $activites = $activites ?? [];
    ?>

    <h1>Suggestions pour "<?= esc((string) $objectif) ?>"</h1>

    <h2>Regimes suggeres</h2>
    <?php if (empty($regimes)): ?>
        <p>Aucun regime trouve.</p>
    <?php else: ?>
        <?php foreach ($regimes as $r): ?>
            <div class="card">
                <strong><?= esc((string) ($r['nom'] ?? '')) ?></strong><br>
                <?= esc((string) ($r['description'] ?? '')) ?><br>
                Prix min: <?= isset($r['prix_min']) ? number_format((float) $r['prix_min'], 2, ',', ' ') : 'N/A' ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <h2>Activites sportives suggerees</h2>
    <?php if (empty($activites)): ?>
        <p>Aucune activite trouvee.</p>
    <?php else: ?>
        <?php foreach ($activites as $a): ?>
            <div class="card">
                <strong><?= esc((string) ($a['nom'] ?? '')) ?></strong><br>
                <?= esc((string) ($a['description'] ?? '')) ?><br>
                Duree: <?= esc((string) ($a['duree_minutes'] ?? '')) ?> min | Calories/h: <?= esc((string) ($a['calories_heure'] ?? '')) ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
