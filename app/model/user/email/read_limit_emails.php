<?php 

	function read_limit_email($id_user, $archive) {
		global $connexion;

		try 
		{
			$query = $connexion->prepare('SELECT * 
											FROM mail_editor
												WHERE id_user=:id_user
												AND archive=:archive
												AND saved = 1
												ORDER BY timestamp DESC
												LIMIT 3');

			$query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
			$query->bindParam(':archive', $archive, PDO::PARAM_INT);

			$query->execute();
			$email = $query->fetchAll();
			$query->closeCursor();

			return $email;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}