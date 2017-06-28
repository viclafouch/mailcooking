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

	function delete_email($id_mail, $id_user) {

		global $connexion;

		try 
		{
			$req = 'DELETE FROM mail_editor
						WHERE id_mail = :id_mail
						AND id_user = :id_user';

			$query = $connexion->prepare($req);

			$query->bindValue(':id_mail', $id_mail, PDO::PARAM_INT);
			$query->bindValue(':id_user', $id_user, PDO::PARAM_INT);


			$query->execute();
			
			return $query;
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}