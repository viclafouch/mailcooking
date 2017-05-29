<?php	

	function lire_commande($id)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM template_commande, users
								                WHERE id_user=user_id
								                AND id_commande=:id
								                ORDER by date_creat DESC');

			// On initialise le paramètre
			$query->bindParam(':id', $id, PDO::PARAM_INT);

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