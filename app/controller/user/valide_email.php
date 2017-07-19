<?php 

	/**
	 *
	 * Fichier de validation de compte inscrit
	 * CCP : Création de l'ensemble des dossiers du client
	 *
	 */

	/**
	 *
	 * GET obligatoire pour la modification du compte
	 *
	 */

	if (isset($_GET['id'])) {

		include_once('app/model/user/account/signup/validate_email.php');

		$valide_email = valide_email($_GET['id']);
	
	    if ($valide_email) {

	    	include_once('app/model/user/account/read_user.php');

			$read_user = read_user($_GET['id']);

			$id_user = $read_user[0]["user_id"];
			$societe_user = mb_strtolower(substr($read_user[0]["societe"], 0, 3));

			$chemin = "client/".$id_user."_".$societe_user."/";
	    	@mkdir($chemin, 0777, true);
	    	@mkdir($chemin.'commandes', 0777, true);
	    	@mkdir($chemin.'templates', 0777, true);
	    	@mkdir($chemin.'exports', 0777, true);
	    	@mkdir($chemin.'emails', 0777, true);
	    	@mkdir($chemin.'factures', 0777, true);

	    	location('home', 'index', 'valide=ok');
	    }
	}

	else {
		die('Il manque ID du user');
	}
