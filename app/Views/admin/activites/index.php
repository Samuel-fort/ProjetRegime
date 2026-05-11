<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des activités sportives</h1>
        <a href="<?= base_url('admin/activites/create') ?>" class="btn btn-primary">+ Nouvelle activité</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('success') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Durée</th>
                    <th>Calories/h</th>
                    <th>Objectif</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activites as $a): ?>
                <tr>
                    <td><strong><?= esc($a['nom']) ?></strong></td>
                    <td><?= $a['duree_minutes'] ?> min</td>
                    <td><?= $a['calories_heure'] ?> kcal</td>
                    <td><?= esc($a['objectif']) ?></td>
                    <td><span class="badge bg-<?= $a['actif'] ? 'success' : 'secondary' ?>"><?= $a['actif'] ? 'Actif' : 'Inactif' ?></span></td>
                    <td>
                        <a href="<?= base_url('admin/activites/edit/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <a href="<?= base_url('admin/activites/delete/' . $a['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette activité ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Retour au dashboard</a>
</div>
<?php echo view('layout/footer'); ?>