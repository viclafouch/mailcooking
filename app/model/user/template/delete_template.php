<?php 

	function delete_template($idOrder)
	{
		global $connexion;

		try 
		{
			$req = 'DELETE FROM template_mail
						WHERE id_template_commande = :id_template_commande';

			$query = $connexion->prepare($req);

			$query->bindValue(':id_template_commande', $idOrder, PDO::PARAM_INT);

			$query->execute();
			
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}