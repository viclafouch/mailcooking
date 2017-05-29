<?php 

	function unsub($id)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM pay_history
												WHERE id_user=:id');

			// On initialise le paramètre
			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();
			$data = $query->fetch();
			$query->closeCursor();

			return $data;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}
