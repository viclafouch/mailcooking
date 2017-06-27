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
		}
	}
	/*=====  End of Page Email  ======*/