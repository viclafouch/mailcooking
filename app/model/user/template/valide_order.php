<?php 

	function get_infos($id)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM template_commande, users
												WHERE id_commande =	:id_commande
												AND id_user=user_id');

			// On initialise le paramètre
			$query->bindParam(':id_commande', $id, PDO::PARAM_INT);
			
			$query->execute();
			$order = $query->fetchAll();
			$query->closeCursor();

			return $order;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}


	function addTemplateMail($dom, $mobile, $id_user, $id_commande)			
	{
		global $connexion;

		try 
		{
			$req = "INSERT INTO template_mail (DOM, 
											medias, 
											id_allow,
											id_template_commande)
							VALUES (:DOM, 
									:medias, 
									:id_allow,
									:id_template_commande)";

			$query = $connexion->prepare($req);

			// On initialise le paramètre
			$query->bindParam(':DOM', $dom, PDO::PARAM_INT);
			$query->bindParam(':medias', $mobile, PDO::PARAM_INT);
			$query->bindParam(':id_allow', $id_user, PDO::PARAM_INT);
			$query->bindParam(':id_template_commande', $id_commande, PDO::PARAM_INT);

			$query->execute();
			
			return $connexion->LastInsertId();
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}