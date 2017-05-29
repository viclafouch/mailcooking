<?php	

	function lire_commandes()			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM template_commande, users
								                WHERE id_user=user_id
								                ORDER by date_creat DESC');

			$query->execute();
			$var = $query->fetchAll();
			$query->closeCursor();
			
			return $var;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}