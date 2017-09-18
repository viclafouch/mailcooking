<?php 

	function countTemplates($allow, $statut) {

		global $connexion;

		try {
			$query = $connexion->prepare('SELECT COUNT(*) AS nb 
											FROM template_mail
												WHERE id_allow=:id_allow
												AND statut=:boul');

			// On initialise le paramètre
			$query->bindParam(':id_allow', $allow, PDO::PARAM_INT);
			$query->bindParam(':boul', $statut, PDO::PARAM_INT);

			$query->execute();
			$result = $query->fetch();

			$query->closeCursor();
			return $result['nb'];
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}