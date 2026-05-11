<?php
$session = session();
if (!$session->get('user_id')) {
    return redirect()->to(base_url('login'));
}

$user_nom = $session->get('user_nom');
$solde_actuel = $user_solde ?? 0; // Va être défini par le contrôleur
?>
<?php echo view('layout/header'); ?>

<div class="container-lg py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm">← Retour au dashboard</a>
            </div>

            <h1 class="mb-4">Mon Portefeuille</h1>
            <p class="lead">Bienvenue, <strong><?= htmlspecialchars($user_nom) ?></strong></p>

            <!-- Solde Card -->
            <div class="card mb-4 border-primary">
                <div class="card-body">
                    <h5 class="card-title">Solde actuel</h5>
                    <p class="card-text text-success" style="font-size: 28px; font-weight: bold;">
                        <span id="solde"><?= number_format($solde_actuel, 2, ',', '') ?></span> €
                    </p>
                </div>
            </div>

            <!-- Codes disponibles -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Codes disponibles</h5>
                    <p class="card-text">
                        BIENV-A1B2C3 (10€)<br>
                        PROMO-G7H8I9 (20€)<br>
                        SUPER-M4N5O6 (50€)<br>
                        GOLD-Y7Z8A1B (30€)<br>
                        VIP-E5F6G7H8 (100€)
                    </p>
                </div>
            </div>

            <!-- Valider code -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Valider un code</h5>
                    <div class="mb-3">
                        <label for="code_input" class="form-label">Code de validation :</label>
                        <input type="text" class="form-control" id="code_input" placeholder="Ex: BIENV-A1B2C3">
                    </div>
                    <button id="btn_valider" class="btn btn-primary w-100">Valider le code</button>
                    <div id="message" class="mt-3"></div>
                </div>
            </div>

            <!-- Historique des transactions -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Historique des transactions</h5>
                    <div id="transactions" class="border rounded p-3" style="height: 250px; overflow-y: auto; background-color: #f8f9fa;">
                        <p class="text-muted small">Aucune transaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view('layout/footer'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let base_url = '<?= base_url() ?>';
    
    chargerSolde();
    
    $('#btn_valider').click(function() {
        let code = $('#code_input').val().trim();
        
        if (!code) {
            afficherErreur('Veuillez entrer un code');
            return;
        }
        
        $.ajax({
            url: base_url + 'wallet/valider_code',
            type: 'POST',
            data: { code: code },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    afficherSucces(response.message + ' (+ ' + response.montant.toFixed(2) + ' €)');
                    $('#solde').text(response.solde.toFixed(2).replace('.', ','));
                    $('#code_input').val('');
                    ajouterTransaction(response.montant, code);
                } else {
                    afficherErreur(response.message);
                }
            },
            error: function() {
                afficherErreur('Erreur serveur');
            }
        });
    });
    
    $('#code_input').keypress(function(e) {
        if (e.which == 13) {
            $('#btn_valider').click();
        }
    });
    
    function afficherSucces(message) {
        $('#message').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    }
    
    function afficherErreur(message) {
        $('#message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    }
    
    function chargerSolde() {
        $.ajax({
            url: base_url + 'wallet/solde',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#solde').text(response.solde.toFixed(2).replace('.', ','));
                }
            }
        });
    }
    
    function ajouterTransaction(montant, code) {
        let date = new Date().toLocaleString('fr-FR');
        let html = '<div class="px-2 py-2 border-bottom small"><strong>+ ' + montant.toFixed(2) + ' €</strong> - Code: <code>' + code + '</code> - ' + date + '</div>';
        
        let transDiv = $('#transactions');
        if (transDiv.find('.text-muted').length > 0) {
            transDiv.empty();
        }
        transDiv.prepend(html);
    }
});
</script>