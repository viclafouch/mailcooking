<?php	

	function delete_email($post, $user)
	{
		global $connexion;

		try 
		{
			$req = 'DELETE FROM mail_editor
						WHERE id_mail = :id_mail
						AND id_user = :id_user';

			$query = $connexion->prepare($req);

			// On initialise les valeurs
			$query->bindValue(':id_mail', $post, PDO::PARAM_INT);
			$query->bindValue(':id_user', $user, PDO::PARAM_INT);


			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}