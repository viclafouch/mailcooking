<?php 

	function lire_users()			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM users
												WHERE user_id=:id');

			// On initialise le paramètre
			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();
			$user = $query->fetchAll();
			$query->closeCursor();

			return $user;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}
