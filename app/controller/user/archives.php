<?php

	/**
	 *
	 * Fichier d'affichage et de modification des archives
	 *
	 */

	/**
	 *
	 * Chaque modification d'archive doit s'effectuer par un POST
	 *
	 */

	if (!empty($_POST)) {

		/**
		 *
		 * Fonction de suppression d'archive (et donc de l'email)
		 *
		 */

		if (isset($_POST['dArchiveID'])) {

			include_once('app/model/user/email/delete_email.php');

			$archiveDeleted = getEmailInfo($_POST['dArchiveID'], $sessionID);

			$chemin = $chemin.'emails/';

			$timestamp = new DateTime($archiveDeleted['timestamp']);
			$emailDate = $timestamp->format('d-m-Y');
			$folder = ''.$archiveDeleted['id_mail'].'_'.$emailDate.'';

			if (count(glob($chemin.$folder."/*")) >= 1 ) {
				removeFiles(glob($chemin.$folder.'/*'));
			}

			if (file_exists($chemin.$folder)) {
				rmdir($chemin.$folder);
			}

			delete_email($_POST['dArchiveID'], $sessionID);
		}

		/**
		 *
		 * Fonction de restauration d'archive et de sa catégorie
		 *
		 */

		elseif (isset($_POST['rArchiveID'])) {

			include_once('app/model/user/archive/update_archive.php');

			include_once('app/model/user/email/update_cat_email.php');

			update_archive($_POST["rArchiveID"], 0, $sessionID);

			update_cat_email(NULL, $_POST['rArchiveID'], $sessionID);
		}
	} 

	/**
	 *
	 * Affichage de la vue
	 *
	 */

	else {

		include_once('app/model/user/email/read_my_all_mails.php');
		
		$archives = read_my_all_mails($_SESSION["user"]["user_id"], 1);

		metadatas('Mes archives', 'Description', 'none');

		include_once("app/view/user/archives.php");
	}