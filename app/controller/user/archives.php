<?php
	if (!empty($_POST)) {

		/* Suppression d'une archive */
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

		/* Restauration d'une archive */
		elseif (isset($_POST['rArchiveID'])) {
			include_once('app/model/user/archive/update_archive.php');

			update_archive($_POST["rArchiveID"], 0, $sessionID);

			include_once('app/model/user/email/update_cat_email.php');

			update_cat_email(NULL, $_POST['rArchiveID'], $sessionID);
		}
	} else {

		include_once('app/model/user/email/read_my_all_mails.php');
		/* Lecture des emails archivés */
		$archives = read_my_all_mails($_SESSION["user"]["user_id"], 1);

		metadatas('Mes archives', 'Description', 'none');

		include_once("app/view/user/archives.php");
	}