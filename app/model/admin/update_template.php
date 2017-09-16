<?php 

	function update_template($id_template, $statut, $dom) {
		global $connexion;

		try {
			$req = "UPDATE template_mail
                  		SET statut = :statut,
                  		DOM = :dom
                  			WHERE id_template = :id_template";

			$query = $connexion->prepare($req);

			$query->bindValue(':statut', $statut, PDO::PARAM_INT);
			$query->bindValue(':id_template', $id_template, PDO::PARAM_INT);
			$query->bindValue(':dom', $dom, PDO::PARAM_STR);

			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}