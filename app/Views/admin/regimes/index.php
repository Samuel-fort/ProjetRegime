<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Régimes</title></head>
<body>

<h1>Gestion des régimes</h1>
<a href="<?= base_url('admin/dashboard') ?>">← Dashboard</a> |
<a href="<?= base_url('admin/regimes/create') ?>">+ Nouveau régime</a>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Objectif</th>
            <th>Variation poids</th>
            <th>Viande %</th>
            <th>Poisson %</th>
            <th>Volaille %</th>
            <th>Prix 30j</th>
            <th>Prix 60j</th>
            <th>Prix 90j</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($regimes as $r): ?>
        <tr>
            <td><?= esc($r['nom']) ?></td>
            <td><?= esc($r['objectif']) ?></td>
            <td><?= $r['variation_poids'] ?> kg</td>
            <td><?= $r['pct_viande'] ?>%</td>
            <td><?= $r['pct_poisson'] ?>%</td>
            <td><?= $r['pct_volaille'] ?>%</td>
            <?php
                $p30 = $p60 = $p90 = '-';
                foreach ($r['prix'] as $p) {
                    if ($p['duree_jours'] == 30) $p30 = number_format($p['prix'], 0, ',', ' ') . ' Ar';
                    if ($p['duree_jours'] == 60) $p60 = number_format($p['prix'], 0, ',', ' ') . ' Ar';
                    if ($p['duree_jours'] == 90) $p90 = number_format($p['prix'], 0, ',', ' ') . ' Ar';
                }
            ?>
            <td><?= $p30 ?></td>
            <td><?= $p60 ?></td>
            <td><?= $p90 ?></td>
            <td><?= $r['actif'] ? 'Oui' : 'Non' ?></td>
            <td>
                <a href="<?= base_url('admin/regimes/edit/' . $r['id']) ?>">Modifier</a> |
                <a href="<?= base_url('admin/regimes/delete/' . $r['id']) ?>"
                   onclick="return confirm('Supprimer ce régime ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>