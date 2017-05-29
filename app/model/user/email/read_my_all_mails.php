<?php 

	function read_my_all_mails($id, $archive)		
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM mail_editor
												WHERE id_user=:id
												AND archive=:boul
												ORDER BY timestamp DESC');

			// On initialise le paramètre
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->bindParam(':boul', $archive, PDO::PARAM_INT);

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