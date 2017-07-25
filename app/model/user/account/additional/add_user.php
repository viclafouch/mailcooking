<?php	

	function add_user($user_additional_admin_id, $user_additional_email, $user_additional_key)
	{
		global $connexion;

		try 
		{
			$req = "INSERT INTO users_additional (user_additional_admin_id, 
											user_additional_email,
											user_additional_key)
							VALUES (:user_additional_admin_id, 
									:user_additional_email,
									:user_additional_key)";

			$query = $connexion->prepare($req);

			$query->bindValue(':user_additional_admin_id', $user_additional_admin_id, PDO::PARAM_INT);
			$query->bindValue(':user_additional_email', $user_additional_email, PDO::PARAM_STR);
			$query->bindValue(':user_additional_key', $user_additional_key, PDO::PARAM_STR);

			$query->execute();
			
			return $connexion->LastInsertId();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}