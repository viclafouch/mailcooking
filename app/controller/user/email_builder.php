<?php

	protec(); 
	
	if (!empty($_POST)) {
		if (isset($_POST["new_img"])) {
			// Enregistrement de l'image
			$options = array( 	
					"wherecolumn"	=>	"id_mail",
					"wherevalue"	=>	$_POST['id_mail']);
		
			$email = selecttable("mail_editor", $options);

			$timestamp = new DateTime($email[0]['timestamp']);
			$email_date = $timestamp->format('d-m-Y');

			$folder = ''.$email[0]['id_mail'].'_'.$email_date.'';

			$chemin = $chemin.'emails/'.$folder;

			$uniqId = uniqid (''.$societe_user.'_', false);

			$random = $uniqId.'.png';

			$savefile = @file_put_contents(	
				$chemin.'/'.$random, 
				base64_decode(explode(",", $_POST["new_img"])[1])
			);

			if($savefile){
				echo $chemin.'/'.$random;
			}
			else {
				echo 'upload fail';
			}
		}
		elseif (isset($_POST['idMail4Thumbs'])) {

			$options = array( "wherecolumn"	=>	"id_mail",
							"wherevalue"	=>	$_POST['idMail4Thumbs']);
		
			$email = selecttable("mail_editor", $options);

			$options = array( "wherecolumn"	=>	"id_template",
							"wherevalue"	=>	$email[0]['template_id']);
		
			$template_mail = selecttable("template_mail", $options);

			$options = array( "wherecolumn"	=>	"id_commande",
							"wherevalue"	=>	$template_mail[0]['id_template_commande']);

			if ($template_mail[0]['id_template_commande'] == 0) {
				echo "template_all/template_public_".$template_mail[0]['id_template']."/";
			}
			else {
				$template_commande = selecttable("template_commande", $options);

				$chemin = ''.$chemin.'templates/';
				$id = $template_mail[0]['id_template_commande'];
				$new_folder = $id.'_'.substr(str_replace(' ', '_', $template_commande[0]["nom_commande"]),0,15);
				echo ''.$chemin.''.$new_folder.'/thumbnails/';
			}
		}
		elseif (isset($_POST['domExport'])) {
			$files = glob($chemin.'exports/*');
			foreach($files as $file) {
				if(is_file($file)) {
				    unlink($file);
				}
			}
			$files = glob($chemin.'exports/images/*');
			foreach($files as $file) {
				if(is_file($file)) {
				    unlink($file);
				}
			}
			
			$path = $chemin.'exports/images';
			@mkdir($path, 0777, false);

			$myFile = $chemin."exports/indsex.html";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = $_POST['domExport'];
			fwrite($fh, $stringData);
			echo $chemin;
		}
		else {
			// Save
			include_once('app/model/user/builder/save.php');

			if ($_POST['emailbackground'] == '') {
				$_POST['emailbackground'] = '#f0f0f0';
			}

			$save = save($_POST['emailTitle'], $_POST['emailDom'],$_POST['emailbackground'], $_POST['emailID'], $_SESSION['user']['user_id']);
		}
	}
	else if (isset($_GET['id'])) {

		$options = array( 	"wherecolumn"	=>	"id_mail",
							"wherevalue"	=>	$_GET['id']);
		
		$user = selecttable("mail_editor", $options);


		$options = array( 	"wherecolumn"	=>	"id_template",
							"wherevalue"	=>	$user[0]['template_id']);
		
		$template = selecttable("template_mail", $options);
		if (!$user) {
			die('id non existant');
		}
		else {
			if ($user[0]['id_user'] == $_SESSION['user']['user_id']) {
				
				metadatas('Email_builder', 'Description', 'none');

				// Appel de la view
				include_once("app/view/user/builder.php");
			} 
			else {
				die('ce n\'est pas ton mail');
			}
		}
	}
	else if (isset($_GET['template'])) {
		$options = array( 	
			"wherecolumn"	=>	"id_template",
			"wherevalue"	=>	$_GET['template']);
			// And need _SESSION_id = id_allow

		$template = selecttable("template_mail", $options);

		if ($template) {
			include_once('app/model/user/email/insert_email.php');

			$mail = new_email($_GET['template'], $_SESSION['user']['user_id'], $template[0]['DOM']);

			if ($mail) {

				$options = array( 	
					"orderby"	=>	"id_mail",
					"order"	=>	'DESC',
					"limit" => 1);

				$email = selecttable("mail_editor", $options);

				$timestamp = new DateTime($email[0]['timestamp']);
				$email_date = $timestamp->format('d-m-Y');
				
				$new_folder = ''.$mail.'_'.$email_date.'';

				@mkdir($chemin.'emails/'.$new_folder."", 0777, true);

				location('user', 'email_builder', 'id='.$mail.'');
				}
			else {
				die();
			}
		}
		else {
			die('template inexistant');
		}
	}
	else {
		die('Aucun ID renseigné');
	}
?>
