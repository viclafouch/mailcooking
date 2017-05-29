<?php	

	function delete_cat($post, $user)
	{
		global $connexion;

		try 
		{
			$req = 'DELETE FROM email_cat
						WHERE cat_id = :cat_id
						AND user_id = :user_id';

			$query = $connexion->prepare($req);

			// On initialise les valeurs
			$query->bindValue(':cat_id', $post, PDO::PARAM_INT);
			$query->bindValue(':user_id', $user, PDO::PARAM_INT);

			$query->execute();
			
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}

		try {
			$req = 'DELETE FROM mail_editor
						WHERE cat_id = :cat_id
						AND archive = :archive
						AND id_user = :id_user';

			$query = $connexion->prepare($req);

			$query->bindValue(':cat_id', $post, PDO::PARAM_INT);
			$query->bindValue(':archive', 0, PDO::PARAM_INT);
			$query->bindValue(':id_user', $user, PDO::PARAM_INT);

			$query->execute();
		}
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}

		try {
			$req = 'UPDATE mail_editor
						SET cat_id = :cat_id
							WHERE cat_id = :id
							AND archive = :archive
							AND id_user = :id_user';

			$query = $connexion->prepare($req);

			$query->bindValue(':id', $post, PDO::PARAM_INT);
			$query->bindValue(':cat_id', NULL, PDO::PARAM_INT);
			$query->bindValue(':archive', 1, PDO::PARAM_INT);
			$query->bindValue(':id_user', $user, PDO::PARAM_INT);

			$query->execute();

			return $query;
		}
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}