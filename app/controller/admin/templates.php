<?php 

	/**
	 *
	 * Fichier d'affichage des templates
	 *
	 */

	/**
	 *
	 * Fonctions de sécurité
	 * Vérification d'une session
	 * Vérfication du rôle de la session
	 *
	 */
	
	protec();
	just_admin();

	if (!empty($_POST)) {
		if (isset($_FILES, $_FILES['templateImg'])) {

		    $DIR_prev = $pathToPublicTemplate.'preview';

		    if (file_exists($DIR_prev)) {
				removeFiles(glob($DIR_prev.'/*'));
			}

		   	$array = explode('.', $_FILES['templateImg']['name']);
		    $NameImageFolder = 'images.'.end($array);

			move_uploaded_file($_FILES['templateImg']['tmp_name'], $DIR_prev.'/'.$NameImageFolder);
			unzip_file($DIR_prev.'/'.$NameImageFolder, $DIR_prev.'/');

			echo $DIR_prev;
			return;
		} elseif (isset($_POST['thumbnail'], $_POST['chemin'], $_POST['dom'], $_POST['medias'], $_POST['title'])) {

			include_once('app/model/user/template/valide_order.php');

			$newTemplate = addTemplateMail($_POST['dom'], $_POST['medias'], $_POST['title'], 'all', null, 1);

			if ($newTemplate) {
				$folder = 'template_public_'.$newTemplate;
				if (@mkdir($pathToPublicTemplate.$folder, 0777, true)) {
					@mkdir($pathToPublicTemplate.$folder.'/images', 0777, true);
					@mkdir($pathToPublicTemplate.$folder.'/thumbnails', 0777, true);
				}

				$savefile = @file_put_contents(	
					$pathToPublicTemplate.$folder.'/thumbnails/thumbnail.png',  
					base64_decode(explode(",", $_POST["thumbnail"])[1])
				);

				if (copy($pathToPublicTemplate.'preview/images.zip', $pathToPublicTemplate.$folder.'/images/images.zip')) {
					unzip_file($pathToPublicTemplate.$folder.'/images/images.zip', $pathToPublicTemplate.$folder.'/images/');
					echo json_encode(array($pathToPublicTemplate.$folder.'/images/', $newTemplate));
					return;
				}

			}
		} elseif (isset($_POST['thumb'])) {
			$chemin = $_POST['chemin'];
			$name = $_POST['nameThumb'];

			$savefile = @file_put_contents(	
				$chemin.$name.'.png',  
				base64_decode(explode(",", $_POST["thumb"])[1])
			);
		} elseif (isset($_POST['DOM'], $_POST['templateID'])) {
			include_once('app/model/admin/update_template.php');

			if (update_template($_POST['templateID'], 0, $_POST['DOM'])) {
				echo json_encode(true);
			}
		}
	} 
	elseif (isset($_GET['selectTemplate'])) {

		include_once('app/model/user/template/valide_order.php');

		$options = array( 
			"wherecolumn"	=>	"id_allow",
			"wherevalue"	=>	$_GET['selectTemplate']
		);
	
		$templates = selecttable("template_mail", $options);

		foreach ($templates as $key => $tp) {
			if (intval($_GET['selectTemplate'])) {
				$commande = get_infos(intval($tp["id_template_commande"]));
				$folder = $tp["id_template_commande"].'_'.substr(str_replace(' ', '_', $commande[0]["nom_commande"]),0,15);
				$path = $chemin.'templates/'.$folder.'/thumbnails/thumbnail.png';
			} else {
				$path = $pathToPublicTemplate.'template_public_'.$tp['id_template'].'/thumbnails/thumbnail.png';
			} ?>

			<li style="background: url('<?= $path; ?>');" data-popup-preview></li>

		<?php }
	}
	else {


		/**
		 *
		 * Affichage de la vue
		 *
		 */

		$options = array( 
			"wherecolumn"	=>	"id_allow",
			"wherevalue"	=>	'all'
		);
	
		$templatePublic = selecttable("template_mail", $options);

		$users = selecttable("users");
		
		metadatas('Les utilisateurs', 'Description', 'none');

		include_once('app/view/admin/templates.php');
	}