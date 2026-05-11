<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des régimes</h1>
        <a href="<?= base_url('admin/regimes/create') ?>" class="btn btn-primary">+ Nouveau régime</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('success') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Objectif</th>
                    <th>Variation</th>
                    <th>Composition</th>
                    <th>Prix 30j</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($regimes as $r): ?>
                <tr>
                    <td><strong><?= esc($r['nom']) ?></strong></td>
                    <td><?= esc($r['objectif']) ?></td>
                    <td><?= $r['variation_poids'] ?> kg</td>
                    <td><small>Viande: <?= $r['pct_viande'] ?>% • Poisson: <?= $r['pct_poisson'] ?>% • Volaille: <?= $r['pct_volaille'] ?>%</small></td>
                    <td>
                        <?php
                            $p30 = '-';
                            foreach ($r['prix'] as $p) {
                                if ($p['duree_jours'] == 30) $p30 = number_format($p['prix'], 0, ',', ' ') . ' Ar';
                            }
                        ?>
                        <?= $p30 ?>
                    </td>
                    <td><span class="badge bg-<?= $r['actif'] ? 'success' : 'secondary' ?>"><?= $r['actif'] ? 'Actif' : 'Inactif' ?></span></td>
                    <td>
                        <a href="<?= base_url('admin/regimes/edit/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <a href="<?= base_url('admin/regimes/delete/' . $r['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce régime ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Retour au dashboard</a>
</div>
<?php echo view('layout/footer'); ?>