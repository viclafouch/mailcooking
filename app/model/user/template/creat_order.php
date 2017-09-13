<?php	

	function new_order($post, $user_id, $statut, $paid, $date) {
		global $connexion;

		try {
			$req = "INSERT INTO template_commande (id_user, 
											nom_commande, 
											commentaire_commande,
											status,
											paid,
											date_creat)
							VALUES (:id_user, 
									:nom_commande, 
									:commentaire_commande, 
									:status,
									:paid,
									:date_creat)";

			$query = $connexion->prepare($req);

			$query->bindValue(':commentaire_commande', $post["commentaire_commande"], PDO::PARAM_STR);
			$query->bindValue(':nom_commande', $post["nom_commande"], PDO::PARAM_STR);
			$query->bindValue(':status', $statut, PDO::PARAM_INT);
			$query->bindValue(':paid', $paid, PDO::PARAM_INT);
			$query->bindValue(':id_user', $user_id, PDO::PARAM_INT);
			$query->bindValue(':date_creat', $date, PDO::PARAM_STR);

			$query->execute();
			
			return $connexion->LastInsertId();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}


	function newTemplateCount($template_commande_id, $user_id, $expiration) {
		global $connexion;

		try {
			$req = "INSERT INTO template_counter (template_commande_id, 
											user_id, 
											expiration_date)
							VALUES (:template_commande_id, 
									:user_id, 
									:expiration_date)";

			$query = $connexion->prepare($req);

			$query->bindValue(':template_commande_id', $template_commande_id, PDO::PARAM_INT);
			$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$query->bindValue(':expiration_date', $expiration, PDO::PARAM_STR);

			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}