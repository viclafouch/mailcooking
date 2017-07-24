<?php 

	function verif_exist_user($email) {
		global $connexion;

		try {
			$query = $connexion->prepare("SELECT *
											FROM users_additional 
											WHERE user_additional_email = :user_additional_email");

			$query->bindValue(':user_additional_email', $email, PDO::PARAM_STR);

			$query->execute(); 
			$account = $query->rowCount();
			return $account;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}
