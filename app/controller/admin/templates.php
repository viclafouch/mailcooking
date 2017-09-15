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
		if (isset($_FILES)) {
			$data['file'] = $_FILES;
		    $data['text'] = $_POST;

		    $DIR_prev = $pathToPublicTemplate.'preview';

		    if (file_exists($DIR_prev)) {
				removeFiles(glob($DIR_prev.'/*'));
			}

		    $NameImageFolder = utf8_encode(str_replace(' ', '_', $_FILES['templateImg']['name']));

			move_uploaded_file($_FILES['templateImg']['tmp_name'], $DIR_prev.'/'.$NameImageFolder);
			unzip_file($DIR_prev.'/'.$NameImageFolder, $DIR_prev.'/');

			echo $DIR_prev;
			return;

		}
	}
	else {


		/**
		 *
		 * Affichage de la vue
		 *
		 */
		
		metadatas('Les utilisateurs', 'Description', 'none');

		include_once('app/view/admin/templates.php');
	}