<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord utilisateur</title>
</head>
<body>
    <main>
        <h1>Tableau de bord</h1>

        <?php
        $user = $user ?? [];
        $imc = $imc ?? 0;
        $categorie = $categorie ?? '';
        $progression = $progression ?? 0;
        $walletLabel = $walletLabel ?? 'Ar';
        ?>

        <section>
            <h2>Profil</h2>
            <p><strong>Nom :</strong> <?= esc((string) ($user['nom'] ?? '')) ?></p>
            <p><strong>Email :</strong> <?= esc((string) ($user['email'] ?? '')) ?></p>
            <p><strong>Genre :</strong> <?= esc((string) ($user['genre'] ?? '')) ?></p>
            <p><strong>Taille :</strong> <?= esc((string) ($user['taille'] ?? '')) ?> cm</p>
            <p><strong>Poids :</strong> <?= esc((string) ($user['poids'] ?? '')) ?> kg</p>
        </section>

        <section>
            <h2>IMC</h2>
            <p><strong>Valeur :</strong> <?= number_format((float) $imc, 2, ',', ' ') ?></p>
            <p><strong>Interprétation :</strong> <?= esc($categorie) ?></p>
            <div style="border:1px solid #000; width:100%; max-width:320px; height:18px;">
                <div style="width:<?= esc((string) $progression) ?>%; height:18px; background:#000;"></div>
            </div>
        </section>

        <section>
            <h2>Wallet</h2>
            <p><strong>Solde :</strong> <?= esc(number_format((float) ($user['wallet'] ?? 0), 2, ',', ' ')) ?> <?= esc($walletLabel) ?></p>
        </section>

        <section>
            <h2>Statut</h2>
            <p><?= ! empty($user['is_gold']) ? 'Membre Gold ✓' : 'Standard' ?></p>
        </section>

        <nav>
            <a href="<?= base_url('profil/modifier') ?>">Modifier le profil</a><br>
            <a href="<?= base_url('objectif/choisir') ?>">Choisir un objectif</a><br>
            <a href="<?= base_url('wallet') ?>">Wallet</a>
        </nav>
    </main>
</body>
</html>
