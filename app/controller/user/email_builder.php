<?php

	protec(); 

	// $options = array( 	
	// 				"wherecolumn"	=>	"id_mail",
	// 				"wherevalue"	=>	$_GET['id']);
		
	// $email = selecttable("mail_editor", $options);

	// if (email[0]['statut'] == 0) {
		
	// };
	
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
			$dom = $_POST['domExport'];
			$email_id = $_POST['ID'];
			$background = $_POST['background'];
			$fonts = $_POST['fonts'];
			$i = $_POST['img'];
			$fixGmailApp = $_POST['fixGmail'];
			$chemin = $chemin.'exports';
			$path = $chemin.'/images';

			$options = array( "wherecolumn"	=>	"id_mail",
							"wherevalue"	=>	$email_id);
		
			$email = selecttable("mail_editor", $options);

			$options = array( "wherecolumn"	=>	"id_template",
							"wherevalue"	=>	$email[0]['template_id']);
		
			$template_mail = selecttable("template_mail", $options);

			$medias = $template_mail[0]['medias'];
			
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
			
			$link = "https://fonts.googleapis.com/css?family=";
			foreach ($fonts as $key => $font) {
				$update_link = $link.$font.'|';
				$link = $update_link;
			}
			$googleFontLink = substr($link, 0, -1);

			foreach ($i as $key => $src) {
				$name_img = explode("/", $src);
				$newDom = str_replace($src, "images/".$name_img[4], $dom);
				$dom = $newDom;

				$newPath = $path.'/';
				$newName  = $newPath.explode('/', $src)[4];
				$copied = copy($src , $newName);
			}

			header ("Content-type: image/png");
			$image = imagecreate(750,1);
			$black = imagecolorallocate($image, 0, 0, 0);
			imagecolortransparent($image, $black);
			imagepng($image, $path."/spacer.png");
			imagedestroy($image);

			$dom = new DOMImplementation;
			$doctype = $dom->createDocumentType('html');
			$document = $dom->createDocument(null, 'html', $dom->createDocumentType("html", 
        	"-//W3C//DTD XHTML 1.0 Transitional//EN", "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"));

			$head = $document->createElement('head');

			$html = $document->getElementsByTagName('html')->item(0);
			$html->setAttribute('lang', 'en');
			$html->setAttribute('xmlns', 'http://www.w3.org/1999/xhtml');
			$html->appendChild($head);

			$metahttp = $document->createElement('meta');
			$metahttp->setAttribute('content', 'text/html; charset=utf-8');
			$metahttp->setAttribute('http-equiv', 'Content-Type');
			$head->appendChild($metahttp);
			 
			$title = $document->createElement('title', $_POST['titleExport']);
			$head->appendChild($title);

			$fonts = $document->createElement('link');
			$fonts->setAttribute('href', $googleFontLink);
			$fonts->setAttribute('rel', 'stylesheet');
			$fonts->setAttribute('type', 'text/css');
			$head->appendChild($fonts);

			$styles = $document->createElement('style', 'body { text-size-adjust:none; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; padding:0; margin:0; background-color:'.$background.'!important; } .ReadMsgBody{ width:100%; } .ExternalClass{ width:100%; } .gmapp{ display:none; display:none!important;}');
			$styles->setAttribute('type', 'text/css');
			$head->appendChild($styles);
			$stylesOutlook = $document->createElement('style', '<!--[if mso]>.fallback-font {font-family: Arial, sans-serif!important;}<![endif]-->');
			$head->appendChild($stylesOutlook);

			$query = $document->createElement('style', $medias);
			$query->setAttribute('type', 'text/css');
			$head->appendChild($query);

			$body = $document->createElement('body', $newDom);
			$body->setAttribute('style', 'background-color:'.$background);
			$html->appendChild($body);
			$fix = $document->createElement('div', $fixGmailApp);
			$body->appendChild($fix);

			$document->formatOutput = true;
			$newDom = $document->saveHTML();

			$file = $chemin."/index.html";
			$fh = fopen($file, 'w');
			$data = htmlspecialchars_decode($newDom);
			fwrite($fh, $data);

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

		else {
			// Save
			include_once('app/model/user/builder/save.php');
			
			$options = array( 	
					"wherecolumn"	=>	"id_mail",
					"wherevalue"	=>	$_POST['emailID']);
		
			$email = selecttable("mail_editor", $options);

			$timestamp = new DateTime($email[0]['timestamp']);
			$email_date = $timestamp->format('d-m-Y');

			$folder = ''.$email[0]['id_mail'].'_'.$email_date.'';

			$chemin = $chemin.'emails/'.$folder;

			$thumbsName = 'thumbs.png';

			$savefile = @file_put_contents(	
				$chemin.'/'.$thumbsName, 
				base64_decode(explode(",", $_POST["thumbs"])[1]));

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
