<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil</title>
</head>
<body>
    <main>
        <h1>Modifier mon profil</h1>

        <?php
        $errorsList = array_map('strval', $errors ?? []);
        $user = $user ?? [];
        ?>

        <?php if (! empty($errorsList)): ?>
            <div>
                <ul>
                    <?php foreach ($errorsList as $error): ?>
                        <li><?= esc((string) $error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('profil/modifier') ?>">
            <?= csrf_field() ?>

            <div>
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" value="<?= esc(old('nom', $user['nom'] ?? '')) ?>">
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= esc(old('email', $user['email'] ?? '')) ?>">
            </div>

            <div>
                <label for="taille">Taille (cm)</label>
                <input type="number" step="0.01" id="taille" name="taille" value="<?= esc(old('taille', $user['taille'] ?? '')) ?>">
            </div>

            <div>
                <label for="poids">Poids (kg)</label>
                <input type="number" step="0.01" id="poids" name="poids" value="<?= esc(old('poids', $user['poids'] ?? '')) ?>">
            </div>

            <button type="submit">Enregistrer les modifications</button>
        </form>
    </main>
</body>
</html>
