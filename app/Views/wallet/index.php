<?php
$session = session();
if (!$session->get('user_id')) {
    return redirect()->to(base_url('login'));
}

$user_nom = $session->get('user_nom');
$solde_actuel = $user_solde ?? 0; // Va être défini par le contrôleur
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mon Portefeuille</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
        }

        h3 {
            text-align: center;
            color: #333;
        }

        h5 {
            color: #555;
            margin-top: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #solde {
            font-size: 24px;
            font-weight: bold;
            color: green;
        }

        #message {
            padding: 10px;
            margin-top: 15px;
            border: 1px solid #ddd;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        #transactions {
            border: 1px solid #ddd;
            padding: 10px;
            height: 200px;
            overflow-y: auto;
            margin-top: 10px;
            background-color: #f9f9f9;
        }

        .transaction {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ddd;
        }

        .nav-back {
            margin-bottom: 20px;
        }

        .nav-back a {
            color: #007bff;
            text-decoration: none;
        }

        .nav-back a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="nav-back">
        <a href="<?= base_url('user/dashboard') ?>">Retour au dashboard</a>
    </div>

    <h3>Mon Portefeuille</h3>
    <p>Bienvenue, <?= htmlspecialchars($user_nom) ?></p>

    <div>
        <h5>Solde actuel</h5>
        <p>Solde: <span id="solde"><?= number_format($solde_actuel, 2, ',', '') ?></span> €</p>
    </div>

    <div>
        <h5>Codes disponibles</h5>
        <p style="font-size: 14px;">
            BIENV-A1B2C3 (10€)<br>
            PROMO-G7H8I9 (20€)<br>
            SUPER-M4N5O6 (50€)<br>
            GOLD-Y7Z8A1B (30€)<br>
            VIP-E5F6G7H8 (100€)
        </p>
    </div>

    <hr>

    <div>
        <label for="code_input">Valider un code :</label>
        <input type="text" id="code_input" placeholder="Ex: BIENV-A1B2C3">
    </div>

    <button id="btn_valider">Valider le code</button>

    <div id="message"></div>

    <hr>

    <h5>Historique des transactions</h5>
    <div id="transactions">
        <p style="color: #999; font-size: 14px;">Aucune transaction</p>
    </div>
</div>

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
        $('#message').html('<div class="success">' + message + '</div>');
    }
    
    function afficherErreur(message) {
        $('#message').html('<div class="error">' + message + '</div>');
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
        let html = '<div class="transaction">Credit: + ' + montant.toFixed(2) + '€ - Code: ' + code + ' - ' + date + '</div>';
        $('#transactions').prepend(html);
    }
});
</script>
</body>
</html>