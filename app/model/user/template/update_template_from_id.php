<?php 

	function update_template_from_id($orderID, $statut) {
		global $connexion;

		try 
		{
			$req = "UPDATE template_mail
					SET statut = :statut
					WHERE id_template = :id_template";
		
					$query = $connexion->prepare($req);
		
					$query->bindValue(':statut', 1, PDO::PARAM_INT);
					$query->bindValue(':id_template', $orderID, PDO::PARAM_INT);
		
					$query->execute();
					return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}