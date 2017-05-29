<?php 

	if (!isset($_POST["nom_commande"])) {

		if (isset($_GET["id"])) {

			// Appel du modèle pour l'affichage des emails
			include_once("app/model/user/email/read_email.php");

			$email = read_email($_GET["id"]);

			echo $email[0]["DOM"];

		}
		else {
			protec();

			// Appel du modèle pour l'affichage des templates
			include_once("app/model/user/template/read_templates.php");

			// Affichage des templates
			$template = read_templates($_SESSION["user"]["user_id"]);

			metadatas('Mes templates', 'Description', 'none');

			// Appel de la view
			include_once("app/view/user/template.php");
		}		
	}
	else {

		// Vérification du fichier
		// $upload = upload('file_commande', 100000000, array('png', 'jpg', 'gif','zip','rar','psd','jpeg', 'gif', 'doc', 'xdoc'));

		// Appel du modèle pour l'insertion de la commande
		include_once("app/model/user/template/creat_order.php");

		// Défintion du statut par défault
		$default_statut = 0;

		// Insertion de la commande
		$new_order = new_order($_POST, $_SESSION["user"]["user_id"], $default_statut);

		if (!$new_order) { location('user', 'template', 'notif=nok'); } 
		else {

			$new_folder = $new_order.'_'.substr(str_replace(' ', '_', $_POST["nom_commande"]),0,15);
			@mkdir($chemin.'commandes/'.$new_folder."", 0777, true);

			$folder = $chemin.'commandes/'.$new_folder.'/';

			// Upload du fichier dans le dossier 
			move_uploaded_file($_FILES['file_commande']['tmp_name'], $folder.$_FILES['file_commande']['name']);

			location('user', 'template', "notif=ok"); 
		}
	}

	