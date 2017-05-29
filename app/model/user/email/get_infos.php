<?php
	if (isset($_GET["id"])) {
		include_once('../../param.inc.php');
		session_start();
		$id = $_GET["id"];
		$title = $_POST['title_new'];
		try 
			{
				$req = 'SELECT * FROM mail_editor
							WHERE id_mail = :id_mail
							AND id_user = :id_user';

				$query = $connexion->prepare($req);

				// On initialise les valeurs
				$query->bindValue(':id_mail', $id, PDO::PARAM_INT);
				$query->bindValue(':id_user', $_SESSION['user']['user_id'], PDO::PARAM_INT);

				$query->execute();
				$email = $query->fetch();

				// $result = array([$id_mail], [$id_mail], [$id_mail], [$id_mail]);

				// $json = 
				// "id_mail: ".$id_mail."";
				// echo json_encode(''.$id_mail.',' .$id_mail.'');
			}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}

		$id_mail = $email["id_mail"];
		$id_user = $email["id_user"];
		$email_name = $title;
		$email_dom = $email["email_dom"];
		$email_background = $email["email_background"];
		$template_name = $email["template_name"];
		$cat_id = $email["cat_id"];

		try 
		{
			$req = "INSERT INTO mail_editor 
								(id_user, 
									email_name,
									email_dom,
									email_background,
									template_name,
									cat_id)
							VALUES (:id_user, 
									:email_name,
									:email_dom,
									:email_background,
									:template_name,
									:cat_id)";

			$query = $connexion->prepare($req);

			// On initialise les valeurs
			$query->bindValue(':id_user', $_SESSION['user']['user_id'], PDO::PARAM_INT);
			$query->bindValue(':email_name', $email_name, PDO::PARAM_STR);
			$query->bindValue(':email_dom', $email_dom, PDO::PARAM_STR);
			$query->bindValue(':email_background', $email_background, PDO::PARAM_STR);
			$query->bindValue(':template_name', $template_name, PDO::PARAM_STR);
			$query->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);

			$query->execute();

			echo $connexion->LastInsertId();

		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}
	