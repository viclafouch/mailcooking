<?php 

	/**
	 *
	 * Fichier d'affichage de la page profil
	 *
	 */

	/**
	 *
	 * Fonction de sécurité
	 * Vérification d'une session
	 *
	 */

	protec();

	/**
	 *
	 * Affichage de la vue
	 * Envoi des données pour connaitre si client ou non
	 *
	 */

	if (!empty($_POST)) {
		if (isset($_POST['account'])) {
			$email = $_POST['account'];
			include_once('/app/model/user/account/additional/add_user.php');
			include_once('/app/model/user/account/additional/verif_exist_user.php');

			if (filter_var($email, FILTER_VALIDATE_EMAIL)) { $valide = true; }
	        
			else { header('Content-Type: application/json'); echo json_encode(array('valide' => false,)); return false; }

			if ($valide) {
				$exist = verif_exist_user($email);
				if ($exist > 0) { header('Content-Type: application/json'); echo json_encode(array( 'empty' => false,)); return false; }

			 	$query = $connexion->prepare('SELECT user_email FROM users WHERE user_email = \''.$email.'\';');
      			$query->execute(array('.$email.' => $email));

        		$res = $query->fetch();
        		if ($res) { header('Content-Type: application/json'); echo json_encode(array( 'empty' => false,)); return false; }


				if ($exist > 0) { header('Content-Type: application/json'); echo json_encode(array( 'empty' => false,)); return false; }

				else {
					$password = uniqid();
					$hash = password_hash($password, PASSWORD_DEFAULT);
					$add = add_user($sessionID, $email, $hash);

					if ($add) {
						$to = $email;
						$from = 'victor.dlf@outlook.fr';
						$subject = "Création de votre compte MailCooking par ".$_SESSION['user']["first_name"]." ".$_SESSION['user']["last_name"];
						$message = '<html><body color="#000">';
						$message .= '<h3>Voici vos identifiants de connexion à la plateforme MailCooking</h3>';
						$message .= '<p>Vos informations de connexion à l\'adresse suivante : <a href="#">mailcooking.fr</a></p>';
						$message .= '<p>Adresse email : '.$email.'</p>';
						$message .= '<p>Mot de passe : '.$password.'</p>';
						$message .= '<p>Connectez-vous dès maintenant et modifier votre mot de passe dans la partie "Mon profil"</p>';
						$message .= '</body></html>';

						$headers = "From: " . strip_tags('mailcooking.noreply@mailcooking.fr') . "\r\n";
						$headers .= "Reply-To: ". strip_tags('victor.dlf@outlook.fr') . "\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						$send = @mail($to, $subject, $message, $headers, "-f " . $from);

						if (!$send) {
							header('Content-Type: application/json');
							echo json_encode(array(
							    'send' => false,
							));
							return false;
						}
					}
				}
			}
		}
		elseif (isset($_POST['idAccount'])) {
			$id = $_POST['idAccount'];

			include_once('/app/model/user/account/additional/delete_user.php');

			$option = array( 
				'wherecolumn' 	=> 	'user_additional_id',
				'wherevalue'	=>	$id,
			);

			$user = selecttable('users_additional', $option);

			if ($user[0]['user_additional_admin_id'] == $sessionID) {
				$delete = delete_user($id);
				if (!$delete) {
					header('Content-Type: application/json');
					echo json_encode(array(
					    'error' => true,
					));
				}
			}
			else {
				header('Content-Type: application/json');
				echo json_encode(array(
				    'error' => true,
				));
			}
		}
		elseif (isset($_POST['password'])) {
			include_once('/app/model/user/account/modif.php');
			$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$update = update_user('password', $hash);
			if (!$update) {
				header('Content-Type: application/json');
				echo json_encode(array(
				    'error' => true,
				));
			}
		}
	}

	else {
		metadatas('Mon compte', 'Description', 'none');

		$option = array( 
			'wherecolumn' 	=> 	'user_id',
			'wherevalue'	=>	$sessionID,
		);

		$sub = selecttable('subscribers', $option);

		if (count($sub) > 0) {
			$subcription = true;
			$plan = $sub[0]['plan'];
		} else {
			$subcription = false;
		}	

		$option = array( 
			'wherecolumn' 	=> 	'user_additional_admin_id',
			'wherevalue'	=>	$sessionID,
		);

		$users_additional = selecttable('users_additional', $option);

		include_once("app/view/user/account.php");
	}