<?php 

	protec();

	// Appel du modèle pour tester l'abonnement
	include_once("app/model/user/account/premium.php");

	// Test de l'abonnement
	$data = test_premium($_SESSION["user"]["user_id"]);

	$premium = "";

	// Verifier si ce n'est pas vide
	if ($data['id_customer'] != '' && $data['id_mandate'] != '' && $data['id_sub'] != '') {
		//  Verifier le statut mendate
		if ($data['status_mendate'] == 'created' || $data['status_mendate'] == 'submited' || $data['status_mendate'] == 'active') {
			// Verifier le statut d'abonnement
			if ($data['status_sub'] == 'created' || $data['status_sub'] == 'submited' || $data['status_sub'] == 'active') {
				// Définition du premium
				$premium = "premium";
			}
		}
	}
	else {
		$premium = "Non abonné";
	}

	metadatas('Mes abonnements', 'Description', 'none');

	// Appel de la view
	include_once("app/view/user/subs.php");

