<?php	

	function new_cat($post, $user)
	{
		global $connexion;

		try 
		{
			$req = "INSERT INTO email_cat (user_id, 
											cat_name)
							VALUES (:user_id, 
									:cat_name)";

			$query = $connexion->prepare($req);

			// On initialise les valeurs
			$query->bindValue(':user_id', $user, PDO::PARAM_INT);
			$query->bindValue(':cat_name', $post, PDO::PARAM_STR);

			$query->execute();
			
			return $connexion->LastInsertId();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}