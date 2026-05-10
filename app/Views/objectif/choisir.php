<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir un objectif</title>
</head>
<body>
    <main>
        <h1>Choisir votre objectif</h1>

        <form method="post" action="<?= base_url('objectif/choisir') ?>">
            <?= csrf_field() ?>

            <?php $current = $current ?? null; ?>

            <div>
                <label>
                    <input type="radio" name="objectif" value="augmenter" <?= $current === 'augmenter' ? 'checked' : '' ?>>
                    🏋️ Augmenter son poids
                </label>
            </div>

            <div>
                <label>
                    <input type="radio" name="objectif" value="reduire" <?= $current === 'reduire' ? 'checked' : '' ?>>
                    🥗 Réduire son poids
                </label>
            </div>

            <div>
                <label>
                    <input type="radio" name="objectif" value="imc_ideal" <?= $current === 'imc_ideal' ? 'checked' : '' ?>>
                    ⚖️ Atteindre son IMC idéal
                </label>
            </div>

            <button type="submit">Valider l'objectif</button>
        </form>
    </main>
</body>
</html>
