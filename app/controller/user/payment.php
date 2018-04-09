<?php 
    metadatas('Payment', 'Description', 'none');	

    $subscription_id = $_SESSION['subscriber']['subscription_id'];
    $subCheck = \Stripe\Subscription::retrieve($subscription_id);
    
	include_once("app/view/user/payment.php");
?>