<?php	

	function delete_cat($cat_id, $user_id) {

		global $connexion;

		try 
		{
			$req = 'DELETE FROM email_cat
						WHERE cat_id = :cat_id
						AND user_id = :user_id';

			$query = $connexion->prepare($req);

			$query->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
			$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

			$query->execute();
			
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}

	function read_emails($email_cat_id, $archive, $id_user) {

		global $connexion;

		try 
		{
			$req = 'SELECT * FROM mail_editor
						WHERE email_cat_id = :email_cat_id
						AND archive = :archive
						AND id_user = :id_user';

			$query = $connexion->prepare($req);

			$query->bindValue(':email_cat_id', $email_cat_id, PDO::PARAM_INT);
			$query->bindValue(':archive', $archive, PDO::PARAM_INT);
			$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);

			$query->execute();
			$emails = $query->fetchAll();
			$query->closeCursor();

			return $emails;
		}
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}

	function delete_email($id_mail, $archive, $id_user) {

		global $connexion;

		try 
		{
			$req = 'DELETE FROM mail_editor
						WHERE id_mail = :id_mail
						AND archive = :archive
						AND id_user = :id_user';

			$query = $connexion->prepare($req);

			$query->bindValue(':id_mail', $id_mail, PDO::PARAM_INT);
			$query->bindValue(':archive', $archive, PDO::PARAM_INT);
			$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);

			$query->execute();
		}
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}