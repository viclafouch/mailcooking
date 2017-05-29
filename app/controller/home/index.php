<?php

	if(!isset($_POST["user_email"])) {

	// Appel de la view
	include_once("app/view/home/index.php");

	} else {

		// Connexion
		if(!isset($_POST["first_name"])) {

			// Appel du modèle pour la vérification
			include_once("app/model/user/account/signin/login.php");

			// Vérification de la connexion
			$retour = login($_POST);

			// Vérification du résultat
			if (!$retour) { location('home', 'index', 'notif=nok'); }
			else { $_SESSION["user"] = $retour; location('user', 'index', "ok"); }
		}
		// Inscription
		else {
			// Appel du modele pour l'insertion d'un user
			include_once('app/model/user/account/signup/register.php');

			$hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

			// Insertion d'un user
			$retour = register($_POST, $hash);

			// Vérification du résultat
			if ($retour) {
				$message = 'lien : <a href="http://preprod-crmcurve.com/mc2016/valide.php?id='. $retour .'">VALIDER LE COMPTE</a>';
				mail_sender($_POST['user_email'], 'Confirmation MailCooking', $message);
				die('envoyé');
			}
		}
	}