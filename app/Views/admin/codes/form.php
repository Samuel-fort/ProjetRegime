<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Nouveau code wallet</title></head>
<body>

<h1>Nouveau code wallet</h1>
<a href="<?= base_url('admin/codes') ?>">← Retour</a>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="<?= base_url('admin/codes/store') ?>" method="post">
    <?= csrf_field() ?>

    <div>
        <label>Code</label><br>
        <input type="text" name="code" placeholder="ex: PROMO-ABC123" required>
    </div>

    <div>
        <label>Montant (Ar)</label><br>
        <input type="number" name="montant" min="1" step="0.01" required>
    </div>

    <div>
        <button type="submit">Créer le code</button>
    </div>

</form>

</body>
</html>