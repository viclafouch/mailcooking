<?php 
	function delete_users($user_additional_admin_id) {

		global $connexion;

		try {
			$query = $connexion->prepare('DELETE FROM users_additional
												WHERE user_additional_admin_id=:user_additional_admin_id');

			$query->bindParam(':user_additional_admin_id', $user_additional_admin_id, PDO::PARAM_INT);

			$query->execute();
			return $query;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}
