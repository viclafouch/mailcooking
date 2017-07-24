<?php	

	function add_user($user_additional_admin_id, $user_additional_email, $user_additional_password)
	{
		global $connexion;

		try 
		{
			$req = "INSERT INTO users_additional (user_additional_admin_id, 
											user_additional_email,
											user_additional_password)
							VALUES (:user_additional_admin_id, 
									:user_additional_email,
									:user_additional_password)";

			$query = $connexion->prepare($req);

			$query->bindValue(':user_additional_admin_id', $user_additional_admin_id, PDO::PARAM_INT);
			$query->bindValue(':user_additional_email', $user_additional_email, PDO::PARAM_STR);
			$query->bindValue(':user_additional_password', $user_additional_password, PDO::PARAM_STR);

			$query->execute();
			
			return $connexion->LastInsertId();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}