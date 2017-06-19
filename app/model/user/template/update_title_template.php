<?php 

	function update_title_template($idTemplate, $title)
	{
		global $connexion;

		try 
		{
			$req = "UPDATE template_mail
                  		SET title_template = :title_template
                  			WHERE id_template = :id_template";

			$query = $connexion->prepare($req);

			$query->bindValue(':title_template', $title, PDO::PARAM_STR);
			$query->bindValue(':id_template', $idTemplate, PDO::PARAM_INT);

			$query->execute();
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}