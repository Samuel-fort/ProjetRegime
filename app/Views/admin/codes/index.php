<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Codes Wallet</title></head>
<body>

<h1>Gestion des codes wallet</h1>
<a href="<?= base_url('admin/dashboard') ?>">← Dashboard</a> |
<a href="<?= base_url('admin/codes/create') ?>">+ Nouveau code</a>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Code</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Utilisé par</th>
            <th>Utilisé le</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($codes as $c): ?>
        <tr>
            <td><?= esc($c['code']) ?></td>
            <td><?= number_format($c['montant'], 2, ',', ' ') ?> Ar</td>
            <td><?= $c['is_used'] ? '<span style="color:red;">Utilisé</span>' : '<span style="color:green;">Disponible</span>' ?></td>
            <td><?= $c['used_by'] ?? '-' ?></td>
            <td><?= $c['used_at'] ?? '-' ?></td>
            <td>
                <?php if (!$c['is_used']): ?>
                    <a href="<?= base_url('admin/codes/delete/' . $c['id']) ?>"
                       onclick="return confirm('Supprimer ce code ?')">Supprimer</a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>