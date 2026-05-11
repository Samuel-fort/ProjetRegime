<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Modifier mon profil</h1>

            <?php
            $errorsList = array_map('strval', $errors ?? []);
            $user = $user ?? [];
            ?>

            <?php if (! empty($errorsList)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errorsList as $error): ?>
                            <li><?= esc((string) $error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('profil/modifier') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= esc(old('nom', $user['nom'] ?? '')) ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= esc(old('email', $user['email'] ?? '')) ?>">
                </div>

                <div class="mb-3">
                    <label for="taille" class="form-label">Taille (cm)</label>
                    <input type="number" step="0.01" class="form-control" id="taille" name="taille" value="<?= esc(old('taille', $user['taille'] ?? '')) ?>">
                </div>

                <div class="mb-3">
                    <label for="poids" class="form-label">Poids (kg)</label>
                    <input type="number" step="0.01" class="form-control" id="poids" name="poids" value="<?= esc(old('poids', $user['poids'] ?? '')) ?>">
                </div>

                <button type="submit" class="btn btn-primary w-100">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</div>
<?php echo view('layout/footer'); ?>
