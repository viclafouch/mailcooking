<div id="defaut_paiement">
    <?php
        if($_SESSION['subscriber']['status'] === 'past_due'){
            echo'<i class="material-icons">clear</i>';
        }
    ?>
    <h3>
        Attention !
    </h3>
    <p>
        <?php
        if($_SESSION['subscriber']['status'] === 'past_due'){
            echo 'Le paiement de votre abonnement semble ne pas être passé, nous allons tenter de le représenter';
        }
        else{
            echo 'Le paiement de votre abonnement semble ne pas être passé';
        }
        ?>
    </p>
    <form action="?module=user&action=updatecard" data-update-card="" method="POST">
        <button class="button_default" id="repaySubscription" data-paymentdefaut="updatecard">
            Le représenter maintenant
        </button>
    </form>
</div>