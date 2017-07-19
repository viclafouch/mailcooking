<?php 

	function subscribe($user_id, $customer_id, $subscription_id, $plan, $date_end_trial) {

		global $connexion;

		try {
			$req = "INSERT INTO subscribers (user_id, 
											customer_id,
											subscription_id, 
											plan,
											date_end_trial)
							VALUES (:user_id, 
									:customer_id,
									:subscription_id,
									:plan, 
									:date_end_trial)";

			$query = $connexion->prepare($req);

			$query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
			$query->bindValue(':customer_id', $customer_id, PDO::PARAM_STR);
			$query->bindValue(':subscription_id', $subscription_id, PDO::PARAM_STR);
			$query->bindValue(':plan', $plan, PDO::PARAM_STR);
			$query->bindValue(':date_end_trial', $date_end_trial, PDO::PARAM_STR);

			$query->execute();
			
			return true;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}