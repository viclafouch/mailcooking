<?php 
	
	/*==================================
	=            Page Email            =
	==================================*/

	if (empty($_POST)) {

		include_once('app/model/user/email/read_my_all_mails.php');
		/* Lecture des emails non archivés */
		$emails = read_my_all_mails($_SESSION["user"]["user_id"], 0);

		/* Lecture des catégories du user SESSION */
		$option = array( 
			'wherecolumn' 	=> 	'user_id',
			'wherevalue'	=>	$_SESSION["user"]["user_id"],
			'orderby'		=> 'cat_id',
			'order' 		=> 'ASC',
		);
		$userCat = selecttable('email_cat', $option);

		/* Insertion des métadonnés */
		metadatas('Mes emails', 'Description', 'none');

		/* Affichage de la vue */
		include_once("app/view/user/emails.php");
	}
	else {
		if (isset($_POST['idCategorie'])) {

			/* Modification d'une catégorie d'un email */
			if (isset($_POST['idEmail'])) {

				if ($_POST['idCategorie'] == 'NULL') { $_POST['idCategorie'] = NULL; }

				include_once('app/model/user/email/update_cat_email.php');

				update_cat_email($_POST['idCategorie'], $_POST['idEmail'], $sessionID);
			}

			/* Modification du titre d'une catégorie */
			elseif (isset($_POST['titleCategorie'])) {

				include_once('app/model/user/categorie/update_cat.php');

				update_cat($_POST['idCategorie'], $_POST['titleCategorie'], $sessionID);
			} 
			
			/* Suppression d'une catégorie */
			else {
				include_once('app/model/user/categorie/delete_cat.php');

				$emails = read_emails($_POST['idCategorie'], 0, $sessionID);

				$chemin = $chemin.'emails/';

				foreach ($emails as $email) {
					$timestamp = new DateTime($email['timestamp']);
					$emailDate = $timestamp->format('d-m-Y');
					$folder = ''.$email['id_mail'].'_'.$emailDate.'';

					if (count(glob($chemin.$folder."/*")) >= 1 ) {
						removeFiles(glob($chemin.$folder.'/*'));
					}

					if (file_exists($chemin.$folder)) {
						rmdir($chemin.$folder);
					}

					delete_email($email['id_mail'], 0, $sessionID);

					echo $chemin.$folder;
				}

				delete_cat($_POST['idCategorie'], $sessionID);
			}
		}
		
		/* Création d'une catégorie */
		elseif (isset($_POST['catName'])) {

			include_once('app/model/user/categorie/new_cat.php');

			$catID = new_cat($_POST['catName'], $sessionID);

			echo $catID;
		}

		/* Duplication d'un email */
		elseif (isset($_POST['idEmail'])) {
			
			include_once('app/model/user/email/duplicate.php');

			$emailDuplicated = getEmailInfo($_POST['idEmail'], $sessionID);
			
			if ($emailDuplicated) {

				$newID = new_email($emailDuplicated['id_user'], $emailDuplicated['email_name'], $emailDuplicated['email_dom'], $emailDuplicated['email_background'], $emailDuplicated['template_id'], $emailDuplicated['email_cat_id'], 1, $emailDuplicated['archive']);


				$timestamp = new DateTime($emailDuplicated['timestamp']);
				$emailDate = $timestamp->format('d-m-Y');

				$newTimestamp = new DateTime();
				$newEmailDate = $newTimestamp->format('d-m-Y');

				$folder = ''.$emailDuplicated['id_mail'].'_'.$emailDate.'';
				$newFolder = ''.$newID.'_'.$newEmailDate.'';

				$src = $chemin.'emails/'.$folder;
				$newSrc = $chemin.'emails/'.$newFolder;

				$newDom = str_replace($src, $newSrc, $emailDuplicated['email_dom']);

				update_src_dom($newDom, $newID, $sessionID);

				@mkdir($chemin.'emails/'.$newFolder."", 0777, true);

				$chemin = $chemin.'emails';

				$src = $chemin.'/'.$folder;
				$dest =  $chemin.'/'.$newFolder;
				$files = glob($chemin.'/'.$folder.'/*.*');

				foreach($files as $file){
					$file_to_go = str_replace($src,$dest,$file);
					copy($file, $file_to_go);
				}

				echo $newFolder;
			}
		}
		/* Insertion en archive d'un email */
		elseif (isset($_POST['archive'])) {

			include_once('app/model/user/archive/update_archive.php');

			update_archive($_POST["archive"], 1, $sessionID);
		}

		/* Suppression d'un email */
		elseif (isset($_POST['trash'])) {

			include_once('app/model/user/email/delete_email.php');

			$emailDeleted = getEmailInfo($_POST['trash'], $sessionID);

			$chemin = $chemin.'emails/';

			$timestamp = new DateTime($emailDeleted['timestamp']);
			$emailDate = $timestamp->format('d-m-Y');
			$folder = ''.$emailDeleted['id_mail'].'_'.$emailDate.'';

			if (count(glob($chemin.$folder."/*")) >= 1 ) {
				removeFiles(glob($chemin.$folder.'/*'));
			}

			if (file_exists($chemin.$folder)) {
				rmdir($chemin.$folder);
			}

			delete_email($_POST['trash'], $sessionID);
		}

	}
	/*=====  End of Page Email  ======*/