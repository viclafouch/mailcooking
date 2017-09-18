<?php 

	function countEmails($id_user, $saved, $archive) {

		global $connexion;

		try {
			$query = $connexion->prepare('SELECT COUNT(*) AS nb 
											FROM mail_editor
												WHERE id_user=:id_user
												AND saved=:saved
												AND archive=:archive');

			// On initialise le paramètre
			$query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
			$query->bindParam(':saved', $saved, PDO::PARAM_INT);
			$query->bindParam(':archive', $archive, PDO::PARAM_INT);

			$query->execute();
			$result = $query->fetch();

			$query->closeCursor();
			return $result['nb'];
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}