<?php
	function getEmailInfo($id_mail, $id_user) {

		global $connexion;

		try 
			{
				$req = 'SELECT * FROM mail_editor
							WHERE id_mail = :id_mail
							AND id_user = :id_user';

				$query = $connexion->prepare($req);

				$query->bindValue(':id_mail', $id_mail, PDO::PARAM_INT);
				$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);

				$query->execute();
				$email = $query->fetch();
				return $email;
			}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}
	
	function new_email($id_user, $email_name, $email_dom, $email_background, $template_id, $email_cat_id, $saved, $archive) {

		global $connexion;

		try 
		{
			$req = "INSERT INTO mail_editor (id_user, 
											email_name,
											email_dom,
											email_background, 
											template_id,
											email_cat_id,
											saved,
											archive)
							VALUES (:id_user, 
									:email_name,
									:email_dom,
									:email_background,
									:template_id,
									:email_cat_id,
									:saved,
									:archive)";

			$query = $connexion->prepare($req);

			$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
			$query->bindValue(':email_name', $email_name, PDO::PARAM_STR);
			$query->bindValue(':email_dom', $email_dom, PDO::PARAM_STR);
			$query->bindValue(':email_background', $email_background, PDO::PARAM_STR);
			$query->bindValue(':template_id', $template_id, PDO::PARAM_INT);
			$query->bindValue(':email_cat_id', $email_cat_id, PDO::PARAM_INT);
			$query->bindValue(':saved', $saved, PDO::PARAM_INT);
			$query->bindValue(':archive', $archive, PDO::PARAM_INT);

			$query->execute();
			
			return $connexion->LastInsertId();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}

	function update_src_dom($email_dom, $id_mail, $id_user) {

		global $connexion;

		try 
		{
			$req = "UPDATE mail_editor
                  		SET email_dom = :email_dom
                  			WHERE id_mail = :id_mail
                  			AND id_user = :id_user";

			$query = $connexion->prepare($req);

			$query->bindValue(':email_dom', $email_dom, PDO::PARAM_STR);
			$query->bindValue(':id_mail', $id_mail, PDO::PARAM_INT);
			$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);

			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}
	