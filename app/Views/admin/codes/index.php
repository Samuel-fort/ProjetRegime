<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des codes wallet</h1>
        <a href="<?= base_url('admin/codes/create') ?>" class="btn btn-primary">+ Nouveau code</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('success') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Utilisé par</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($codes as $c): ?>
                <tr>
                    <td><code><?= esc($c['code']) ?></code></td>
                    <td><?= number_format($c['montant'], 2, ',', ' ') ?> Ar</td>
                    <td><span class="badge bg-<?= $c['is_used'] ? 'danger' : 'success' ?>"><?= $c['is_used'] ? 'Utilisé' : 'Disponible' ?></span></td>
                    <td><?= $c['used_by'] ?? '-' ?></td>
                    <td><?= $c['used_at'] ?? '-' ?></td>
                    <td>
                        <?php if (!$c['is_used']): ?>
                            <a href="<?= base_url('admin/codes/delete/' . $c['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce code ?')">Supprimer</a>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Retour au dashboard</a>
</div>
<?php echo view('layout/footer'); ?>