<?php	

	function new_email($template, $user, $dom)
	{
		global $connexion;

		try 
		{
			$req = "INSERT INTO mail_editor (id_user, 
											email_dom,
											template_name)
							VALUES (:id_user, 
									:email_dom,
									:template_name)";

			$query = $connexion->prepare($req);

			// On initialise les valeurs
			$query->bindValue(':id_user', $user, PDO::PARAM_INT);
			$query->bindValue(':email_dom', $dom, PDO::PARAM_STR);
			$query->bindValue(':template_name', $template, PDO::PARAM_STR);

			$query->execute();
			
			return $connexion->LastInsertId();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}