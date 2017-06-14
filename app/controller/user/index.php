<?php 
	
	if (!isset($_POST["cat_name"])) {

		// Delete categorie
		if (isset($_POST['cat_id'])) {
			include_once('app/model/user/categorie/delete_cat.php');

			$delete = delete_cat($_POST["cat_id"], $_SESSION["user"]["user_id"]);
		}

		// Update email's categorie
		if (isset($_POST['email_id_tupdate'])) {
			include_once('app/model/user/email/update_cat_email.php');

			$update = update_cat_email($_POST['id_cat'], $_POST["email_id_tupdate"], $_SESSION["user"]["user_id"]);
		}

		// Delete email
		if (isset($_POST['email_id_tdelete'])) {
			include_once('app/model/user/email/delete_email.php');

			$delete = delete_email($_POST["email_id_tdelete"], $_SESSION["user"]["user_id"]);
		}

		// Moving to archive
		if (isset($_POST['email_id_tarchive'])) {
			include_once('app/model/user/email/move_to_archive.php');

			$moving = move_to_archive(1, $_POST["email_id_tarchive"], $_SESSION["user"]["user_id"]);
		}

		// Secu
		protec();

		// Read all emails
		include_once('app/model/user/email/read_my_all_mails.php');

		$emails = read_my_all_mails($_SESSION["user"]["user_id"], 0);

		// Read users's cat
		$cat_user = selecttable('email_cat', 
				array(	'wherecolumn' 	=> 	'user_id',
						'wherevalue'	=>	$_SESSION["user"]["user_id"],
						'orderby' => 'cat_id',
						'order' => 'ASC',
					));

		// Verif if $emails is empty
		if (!empty($emails)) {
			$email = selecttable('mail_editor', 
				array(	'wherecolumn' 	=> 	'cat_id',
						'wherevalue'	=>	$emails[0]["cat_id"]
			));
		}

		metadatas('Mes emails', 'Description', 'none');
		// Appel de la view
		include_once("app/view/user/index.php");
	}

	// Update categorie
	else if (isset($_GET['cat_id'])) {
		include_once('app/model/user/categorie/update_cat.php');

		$update = update_cat($_GET['cat_id'], $_POST["cat_name"], $_SESSION["user"]["user_id"]);
	}

	// Create categorie
	else {
		include_once('app/model/user/categorie/new_cat.php');

		$post = new_cat($_POST['cat_name'], $_SESSION["user"]["user_id"]);
		echo $post;
	}