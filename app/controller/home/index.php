<?php

	/**
	 *
	 * Fichier d'affichage de la page d'accueil
	 *
	 */
	if (isset($_POST["user_email"])) {
		session_unset();
		/**
		 *
		 * Fonction de connexion/login au site
		 *
		 */
		
		if (!isset($_POST["first_name"])) {
			include_once("app/model/user/account/signin/login.php");

			// session_destroy();
			$checkAdmin = loginAdmin($_POST);
			$checkUser = loginUser($_POST);
			if ($checkAdmin || $checkUser) {
				if ($checkAdmin) { 
					$_SESSION["user"] = $checkAdmin;
				} 
				else { 
					$option = array( 
						'wherecolumn' 	=> 	'user_id',
						'wherevalue'	=>	$checkUser['user_additional_admin_id'],
					);
					
					$user = selecttable('users', $option);
					$_SESSION['user'] = $user[0];

					$_SESSION['additional'] = $checkUser;

				}
				location('user', 'index');
			}
			else {
				die('Adresse email ou mot de passe invalide');
			}
		}

		/**
		 *
		 * Fonction d'inscription/register au site
		 * CCP : Envoie d'un email de demande de validation d'inscription
		 *
		 */

		else {
		
			include_once('app/model/user/account/signup/register.php');

			$hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

			$retour = register($_POST, $hash);
			$key = $_SESSION['token'];
			if ($retour) {
				$message = 'lien : <a href="http://localhost/mailcooking/?module=user&action=valide_email&id='. $retour .'&key='.$key.'">VALIDER LE COMPTE</a>';
				mail_sender($_POST['user_email'], 'Confirmation MailCooking', $message);
				die('envoyé');
			}
		}
	} 

	/**
	 *
	 * Affichage de la vue
	 *
	 */

	else {

		include_once("app/view/home/index.php");

	}
