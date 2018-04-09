<?php
    function checkStatus(){
            $subscription_id = $_SESSION['subscriber']['subscription_id'];
            $subCheck = \Stripe\Subscription::retrieve($subscription_id);
            if($subCheck['status'] != $_SESSION['subscriber']['status']){
                updateStatus($_SESSION['subscriber']['user_id'], $subCheck['status']);
            }
    }
   

    function updateStatus($user_id, $status_stripe){
        global $connexion;
        try {
			$req = "UPDATE subscribers SET status_stripe=:status_stripe WHERE user_id=:user_id";

			$query = $connexion->prepare($req);

			$query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
			$query->bindValue(':status_stripe', $status_stripe, PDO::PARAM_STR);

			$query->execute();
            
            $_SESSION['subscriber']['status_stripe'] =  $status_stripe;
			return true;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
    }
?>