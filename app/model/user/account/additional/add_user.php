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

	function valide_user_add($user_additional_id, $user_additional_password, $statut) {
	
		global $connexion;

		try {

			$query = $connexion->prepare('UPDATE users_additional
				SET user_additional_password = :user_additional_password,
				statut = :statut
				WHERE user_additional_id = :user_additional_id');

			$query->BindValue(":user_additional_id",    $user_additional_id,    PDO::PARAM_STR);
			$query->BindValue(":user_additional_password", $user_additional_password, PDO::PARAM_STR);
			$query->BindValue(":statut", $statut, PDO::PARAM_STR);

			$query->execute();
			$query->closeCursor();

			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}