<?php ?>
<div class="wallet-container">
    <h2>Valider un code</h2>
    
    <input type="text" id="code_input" placeholder="Entrez votre code" class="form-control">
    <button id="btn_valider" class="btn btn-primary">Valider</button>
    
    <div id="message" style="margin-top: 15px;"></div>
    <p>Solde actuel: <strong id="solde">0.00</strong> €</p>
</div>

<script>
$(document).ready(function() {
    let base_url = '<?= base_url() ?>';
    
    $('#btn_valider').click(function() {
        $.ajax({
            url: base_url + 'wallet/valider_code',
            type: 'POST',
            data: { code: $('#code_input').val() },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#message').html('<div class="alert alert-success">' + res.message + ' (+ ' + res.montant + '€)</div>');
                    $('#solde').text(res.solde);
                    $('#code_input').val('');
                } else {
                    $('#message').html('<div class="alert alert-danger">' + res.message + '</div>');
                }
            }
        });
    });
});
</script>