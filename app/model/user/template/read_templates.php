<?php 

	function read_templates($allow, $orderby)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM template_mail
												WHERE id_allow = :id
												AND statut = 1
												ORDER BY upload_template_date '.$orderby);

			// On initialise le paramètre
			$query->bindParam(':id', $allow, PDO::PARAM_INT);

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