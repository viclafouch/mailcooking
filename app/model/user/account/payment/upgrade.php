<?php 

	function upgrade($user_id, $plan) {

		global $connexion;

		try {
			$req = "UPDATE  subscribers
              SET plan = :plan
                WHERE user_id = :user_id";

			$query = $connexion->prepare($req);

			$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$query->bindValue(':plan', $plan, PDO::PARAM_INT);

			$query->execute();
			
			return true;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}