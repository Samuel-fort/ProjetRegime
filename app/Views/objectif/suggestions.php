<!DOCTYPE html>
<<<<<<< HEAD
<?php
/*
 * Vue des suggestions de régimes et activités sportives selon l'objectif de l'utilisateur
 */
?>
=======
>>>>>>> correction
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestions selon objectif</title>
</head>
<body>
    <main>
        <?php
        $objectif = $objectif ?? '';
        $regimes = $regimes ?? [];
        $activites = $activites ?? [];
        ?>

        <h1>Suggestions pour "<?= esc((string) $objectif) ?>"</h1>

        <section>
            <h2>Régimes suggérés</h2>
            <?php if (empty($regimes)): ?>
                <p>Aucun régime trouvé pour cet objectif.</p>
            <?php else: ?>
                <?php foreach ($regimes as $r): ?>
                    <article>
                        <h3><?= esc((string) ($r['nom'] ?? '')) ?></h3>
                        <p><?= esc((string) ($r['description'] ?? '')) ?></p>
                        <p>Prix à partir de : <?= isset($r['prix_min']) ? number_format((float) $r['prix_min'], 2, ',', ' ') : 'N/A' ?> €</p>
                        <p>Variation de poids : <?= esc((string) ($r['variation_poids'] ?? '')) ?> kg</p>
                        <p>% viande: <?= esc((string) ($r['pct_viande'] ?? '')) ?> • % poisson: <?= esc((string) ($r['pct_poisson'] ?? '')) ?> • % volaille: <?= esc((string) ($r['pct_volaille'] ?? '')) ?></p>
                        <p><a href="#">Voir le détail</a></p>
                    </article>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <section>
            <h2>Activités sportives suggérées</h2>
            <?php if (empty($activites)): ?>
                <p>Aucune activité trouvée pour cet objectif.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($activites as $a): ?>
                        <li>
                            <strong><?= esc((string) ($a['nom'] ?? '')) ?></strong> — <?= esc((string) ($a['description'] ?? '')) ?>
                            (<?= esc((string) ($a['duree_minutes'] ?? '')) ?> min, <?= esc((string) ($a['calories_heure'] ?? '')) ?> kcal/h)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <p><a href="<?= base_url('user/dashboard') ?>">Retour au dashboard</a></p>
    </main>
</body>
</html>
