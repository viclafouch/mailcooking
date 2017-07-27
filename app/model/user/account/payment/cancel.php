<?php 

	function cancel_subscription($subscription_id) {

		global $connexion;

		try {
			$req = 'DELETE FROM subscribers
						WHERE subscription_id = :subscription_id';

			$query = $connexion->prepare($req);

			$query->bindValue(':subscription_id', $subscription_id, PDO::PARAM_STR);

			$query->execute();

			return true;
			
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}