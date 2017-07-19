<?php

	/**
	 *
	 * Fichier d'envoie d'email pour mot de passe oublié
	 * POST obligatoire
	 *
	 */

	if (isset($_POST['user_email'])) {

		include_once("app/model/user/account/recovery/form_password.php");

		$data = password($_POST['user_email']);

		/**
		 *
		 * Fonction de création d'un id unique pour la réinitialisation du mot de passe
		 * CCP : Envoi d'un email de réinitialisation d'email
		 *
		 */

		if ($data['user_email'] == $_POST['user_email']) {
			$id = uniqid('PASS_', true);
			$timestamp = time() + 86400;
			$data = $_POST['user_email'];

			include_once("app/model/user/account/recovery/insert_idTemp.php");

			$password = password_forget($id, $data, $timestamp);

			if ($password) {
				// Change URL !!
				$message = 'lien de réinitialisation mot de passe : <a href="recovery_password?id='.$id.'">ICI</a>';
				mail_sender($_POST['user_email'], 'Réinitialisation mot de passe MailCooking', $message);
				die('send');
			}
		}
		else {
			die('Email non existant en bdd');
		}
	}