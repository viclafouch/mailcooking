<?php 

	function update_template($orderID, $statut)
	{
		global $connexion;

		try 
		{
			$req = "UPDATE template_mail
                  		SET statut = :statut
                  			WHERE id_template_commande = :id_template_commande";

			$query = $connexion->prepare($req);

			$query->bindValue(':statut', $statut, PDO::PARAM_INT);
			$query->bindValue(':id_template_commande', $orderID, PDO::PARAM_INT);

			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}