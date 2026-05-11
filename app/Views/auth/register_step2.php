<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title mb-2 text-center">Créer un compte</h2>
                    <p class="text-center text-muted mb-4">Étape 2/2 – Informations physiques</p>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $e): ?>
                                    <li><?= esc($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('register/step2') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="taille" class="form-label">Taille (cm)</label>
                            <input type="number" class="form-control" id="taille" name="taille" min="50" max="250" step="0.1"
                                   value="<?= esc($old['taille'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="poids" class="form-label">Poids (kg)</label>
                            <input type="number" class="form-control" id="poids" name="poids" min="10" max="300" step="0.1"
                                   value="<?= esc($old['poids'] ?? '') ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">← Retour</button>
                            <button type="submit" class="btn btn-primary flex-grow-1">Créer mon compte</button>
                        </div>
                    </form>

                    <hr class="my-4">
                    <p class="text-center mb-0">Vous avez un compte ? <a href="<?= base_url('login') ?>">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo view('layout/footer'); ?>
</html>