<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Activités sportives</title></head>
<body>

<h1>Gestion des activités sportives</h1>
<a href="<?= base_url('admin/dashboard') ?>">← Dashboard</a> |
<a href="<?= base_url('admin/activites/create') ?>">+ Nouvelle activité</a>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Durée (min)</th>
            <th>Calories/heure</th>
            <th>Objectif</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($activites as $a): ?>
        <tr>
            <td><?= esc($a['nom']) ?></td>
            <td><?= $a['duree_minutes'] ?></td>
            <td><?= $a['calories_heure'] ?></td>
            <td><?= esc($a['objectif']) ?></td>
            <td><?= $a['actif'] ? 'Oui' : 'Non' ?></td>
            <td>
                <a href="<?= base_url('admin/activites/edit/' . $a['id']) ?>">Modifier</a> |
                <a href="<?= base_url('admin/activites/delete/' . $a['id']) ?>"
                   onclick="return confirm('Supprimer cette activité ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>