<?php	

	function update_cat($cat_id, $cat_name, $user_id)
	{
		global $connexion;

		try 
		{
			$req = "UPDATE email_cat
                  		SET cat_name = :cat_name
                  			WHERE cat_id = :cat_id
                  			AND user_id = :user_id";

			$query = $connexion->prepare($req);

			// On initialise les valeurs
			$query->bindValue(':cat_name', $cat_name, PDO::PARAM_STR);
			$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$query->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);

			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}