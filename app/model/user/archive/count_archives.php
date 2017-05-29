<?php 

	function count_archives($id, $archive)		
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT COUNT(*) AS nb 
											FROM mail_editor
												WHERE id_user=:id
												AND archive=:boul');

			// On initialise le paramètre
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->bindParam(':boul', $archive, PDO::PARAM_INT);

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