<?php 

	function read_templates($id)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM template_mail
												WHERE id_allow = "all" OR id_allow = :id
												AND statut = 1');

			// On initialise le paramètre
			$query->bindParam(':id', $id, PDO::PARAM_INT);

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