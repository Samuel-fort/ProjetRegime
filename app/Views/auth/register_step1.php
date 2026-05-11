<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title mb-2 text-center">Créer un compte</h2>
                    <p class="text-center text-muted mb-4">Étape 1/2 – Informations personnelles</p>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $e): ?>
                                    <li><?= esc($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('register/step1') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="nom" name="nom"
                                   value="<?= esc($old['nom'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?= esc($old['email'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe_confirm" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="mot_de_passe_confirm" name="mot_de_passe_confirm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Genre</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="genre" value="homme" id="homme"
                                    <?= (($old['genre'] ?? '') === 'homme') ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="homme">Homme</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="genre" value="femme" id="femme"
                                    <?= (($old['genre'] ?? '') === 'femme') ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="femme">Femme</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Continuer →</button>
                    </form>

                    <hr class="my-4">
                    <p class="text-center mb-0">Déjà un compte ? <a href="<?= base_url('/') ?>">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo view('layout/footer'); ?>
</html>