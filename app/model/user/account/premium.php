<?php 
	function test_premium($user_id) {

		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM pay_history
												WHERE id_user=:id');

			// On initialise le paramètre
			$query->bindParam(':id', $user_id, PDO::PARAM_INT);

			$query->execute();
			$premium = $query->fetch();
			$query->closeCursor();

			return $premium;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}
?>