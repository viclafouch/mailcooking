<?php	

	function new_order($post, $user_id, $statut)
	{
		global $connexion;

		try 
		{
			$req = "INSERT INTO template_commande (id_user, 
											nom_commande, 
											commentaire_commande,
											status)
							VALUES (:id_user, 
									:nom_commande, 
									:commentaire_commande, 
									:status)";

			$query = $connexion->prepare($req);

			// On initialise les valeurs
			$query->bindValue(':commentaire_commande', $post["commentaire_commande"], PDO::PARAM_STR);
			$query->bindValue(':nom_commande', $post["nom_commande"], PDO::PARAM_STR);
			$query->bindValue(':status', $statut, PDO::PARAM_STR);
			$query->bindValue(':id_user', $user_id, PDO::PARAM_INT);

			$query->execute();
			
			return $connexion->LastInsertId();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}