<?php 

		// Secu
		protec();

		// Recovery Email
		if (isset($_POST['data_restore'])) {

			include_once('app/model/user/archive/recovery_email.php');

			$data = json_decode($_POST['data_restore']);

			foreach($data as $d){
				$recovery_email = recovery_email(0, $d ,$_SESSION["user"]["user_id"]);
			}
		}
		// Delete Email
		else if (isset($_POST['data_delete'])) {

			include_once('app/model/user/archive/delete_email.php');

			$data = json_decode($_POST['data_delete']);

			foreach($data as $d){
				$delete_email = delete_email($d ,$_SESSION["user"]["user_id"]);
			}
		}
		else {

			include_once('app/model/user/archive/count_archives.php');

			$nb_archives = count_archives($_SESSION["user"]["user_id"], 1);

			// Read all emails
			include_once('app/model/user/email/read_my_all_mails.php');

			$emails = read_my_all_mails($_SESSION["user"]["user_id"], 1);

			metadatas('Mes emails', 'Description', 'none');
			// Appel de la view
			include_once("app/view/user/archives.php");
		}

