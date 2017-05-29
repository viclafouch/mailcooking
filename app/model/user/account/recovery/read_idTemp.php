<?php 

	function read_idTemp($id)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM forgotten_pass
												WHERE id_unique=:id');

			// On initialise le paramètre
			$query->bindParam(':id', $id, PDO::PARAM_STR);

			$query->execute();
			$var = $query->fetch();
			$query->closeCursor();

			return $var;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}