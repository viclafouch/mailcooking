<?php	

	function recovery_email($boulean, $id, $user)
	{
		global $connexion;

		try 
		{
			$req = "UPDATE mail_editor
                  		SET archive = :archive
                  			WHERE id_mail = :id_mail
                  			AND id_user = :id_user";

			$query = $connexion->prepare($req);

			// On initialise les valeurs
			$query->bindValue(':archive', $boulean, PDO::PARAM_INT);
			$query->bindValue(':id_user', $user, PDO::PARAM_INT);
			$query->bindValue(':id_mail', $id, PDO::PARAM_INT);

			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}