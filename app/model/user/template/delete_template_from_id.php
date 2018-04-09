<?php 

	function delete_template_from_id($idOrder)
	{
		global $connexion;

		try 
		{
			$req = 'DELETE FROM template_mail WHERE id_template = :id_template';

            $query = $connexion->prepare($req);

            $query->bindValue(':id_template', $orderID, PDO::PARAM_INT);

            $query->execute();
			
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}