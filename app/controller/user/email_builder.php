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
			$chemin = $chemin.'exports';
			$path = $chemin.'/images';
			function removeFiles($path) {
				foreach($path as $file) {
					if(is_file($file)) {
					    unlink($file);
					}
				}
			}
			if (count(glob($chemin."/*")) === 0 ) {
				@mkdir($path, 0777, true);
			}
			else {
				removeFiles(glob($chemin.'/*'));
				if (file_exists($path)) {
					removeFiles(glob($chemin.'/images/*'));
				}
			}
			
			$file = $chemin."/index.html";
			$fh = fopen($file, 'w');
			$data = $_POST['domExport'];
			fwrite($fh, $data);
			
			$i = $_POST['img'];

			foreach ($i as $src){
				$imagePath = $src;
				$newPath = $path.'/';
				$newName  = $newPath.explode('/', $src)[4];
				$copied = copy($imagePath , $newName);
			}
			
			if (count(glob($path."/*")) !== 0 ) {
				$zip = new ZipArchive();
				$rootPath = realpath($path);

				$zip->open($chemin.'/'.$_POST['titleExport'].'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

				$files = new RecursiveIteratorIterator(
				    new RecursiveDirectoryIterator($rootPath),
				    RecursiveIteratorIterator::LEAVES_ONLY
				);
				$zip->addFile($file,'index.html');
				foreach ($files as $name => $file)
				{
				    if (!$file->isDir())
				    {
				        $filePath = $file->getRealPath();
				        $relativePath = substr($filePath, strlen($rootPath) + 1);

				        $zip->addFile($filePath, 'images/'.$relativePath);
				    }
				}
				$zip->close();
				echo $chemin.'/'.$_POST['titleExport'].'.zip';
			}
		}

		elseif (isset($_POST['test'])) {
			echo '<script>window.open("'.$_POST['test'].'")</script>';
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
