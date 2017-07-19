<?php 

	/**
	 *
	 * Fichier d'affichage de la page profil
	 *
	 */

	/**
	 *
	 * Fonction de sécurité
	 * Vérification d'une session
	 *
	 */

	protec();

	/**
	 *
	 * Affichage de la vue
	 * Envoi des données pour connaitre si client ou non
	 *
	 */

	metadatas('Mon compte', 'Description', 'none');

	$option = array( 
		'wherecolumn' 	=> 	'user_id',
		'wherevalue'	=>	$sessionID,
	);

	$sub = selecttable('subscribers', $option);

	if (count($sub) > 0) {
		$subcription = true;
		$plan = $sub[0]['plan'];
	} else {
		$subcription = false;
	}	

	include_once("app/view/user/account.php");

