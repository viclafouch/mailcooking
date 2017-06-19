<?php 

	function preview_template($id, $allow)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM template_mail
												WHERE id_template = :id_template
												AND id_allow = :id_allow
												AND statut = 1');

			// On initialise le paramètre
			$query->bindParam(':id_template', $id, PDO::PARAM_INT);
			$query->bindParam(':id_allow', $allow, PDO::PARAM_INT);

			$query->execute();
			$template = $query->fetchAll();
			$query->closeCursor();

			return $template;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}