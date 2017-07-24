<?php 
	function delete_user($user_additional_id){
		global $connexion;

		try {
			$query = $connexion->prepare('DELETE FROM users_additional
												WHERE user_additional_id=:user_additional_id');

			$query->bindParam(':user_additional_id', $user_additional_id, PDO::PARAM_INT);

			$query->execute();
			return $query;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}
