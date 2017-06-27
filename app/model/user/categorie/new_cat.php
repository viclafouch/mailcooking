<?php	

	function new_cat($cat_name, $user_id)
	{
		global $connexion;

		try 
		{
			$req = "INSERT INTO email_cat (user_id, 
											cat_name)
							VALUES (:user_id, 
									:cat_name)";

			$query = $connexion->prepare($req);

			$query->bindValue(':cat_name', $cat_name, PDO::PARAM_STR);
			$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

			$query->execute();

			return $connexion->LastInsertId();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}