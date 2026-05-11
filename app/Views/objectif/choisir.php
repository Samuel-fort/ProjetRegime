<?php echo view('layout/header'); ?>
<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Choisir votre objectif</h1>

            <?php $current = $current ?? ''; ?>

            <form method="post" action="<?= base_url('objectif/choisir') ?>">
                <?= csrf_field() ?>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="objectif" value="augmenter" id="augmenter" 
                                <?= $current === 'augmenter' ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="augmenter">
                                <strong>Augmenter son poids</strong>
                                <p class="text-muted">Pour prendre du muscle</p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="objectif" value="reduire" id="reduire" 
                                <?= $current === 'reduire' ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="reduire">
                                <strong>Réduire son poids</strong>
                                <p class="text-muted">Pour mincir sainement</p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="objectif" value="imc_ideal" id="imc_ideal" 
                                <?= $current === 'imc_ideal' ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="imc_ideal">
                                <strong>Atteindre son IMC idéal</strong>
                                <p class="text-muted">Pour un meilleur équilibre</p>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Valider l'objectif</button>
            </form>
        </div>
    </div>
</div>
<?php echo view('layout/footer'); ?>
