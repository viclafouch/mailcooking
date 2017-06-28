<?php 

	function update_archive($id_mail, $archive, $id_user) {

		global $connexion;

		try 
		{
			$req = "UPDATE mail_editor
                  		SET archive = :archive
                  			WHERE id_mail = :id_mail
                  			AND id_user = :id_user";

			$query = $connexion->prepare($req);

			$query->bindValue(':id_mail', $id_mail, PDO::PARAM_INT);
			$query->bindValue(':archive', $archive, PDO::PARAM_INT);
			$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);

			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}