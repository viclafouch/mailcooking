<?php 

	/**
	 *
	 * Fichier de réinitialisation de mot de passe
	 * GET obligatoire
	 *
	 */

	if (!isset($_GET['id'])) {
		die('Paramètre ID manquant');
	}

	/**
	 *
	 * Fonction de réinitialisation d'email
	 * GET & POST obligatoire
	 *
	 */

	else {

		if (isset($_POST['password1']) && isset($_POST['password2'])) {

			include_once('app/model/user/account/recovery/read_idTemp.php');

			$data = read_idTemp($_GET["id"]);

			if ($_POST['password1'] == $_POST['password2']) {
				$hash = password_hash($_POST['password1'], PASSWORD_DEFAULT);

				include_once('app/model/user/account/recovery/update_password.php');

				$update = update_password($hash, $data["email"]);

				if($update) {

					include_once('app/model/user/account/recovery/delete_idTemp.php');

					$delete = delete_row_forgotten_pass($data["email"]);

					if ($delete) {
						die('Mot de passe mis à jour');
						// Fonction d'envoie d'email pour confirmer l'update ?
					}
				}
			}
			else {
				die('Les mots de passes ne sont pas identiques');
			}
		}

		/**
		 *
		 * Affichage de la vue
		 *
		 */
		
		else {
			include_once('app/view/home/recovery_password.php');
		}
	}