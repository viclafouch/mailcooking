<?php
	require 'lib/composer/vendor/autoload.php';

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

	$client = new \GoCardlessPro\Client([
		// We recommend storing your access token in an environment variable for security, but you could include it as a string directly in your code
		'access_token' => "sandbox_pvp-IW0V7OWF_qTsgtTsjxuZFSUlDnvjCVMXI1Aw",
		// Change me to LIVE when you're ready to go live
		'environment' => \GoCardlessPro\Environment::SANDBOX
	]);

	include_once("app/model/user/account/payment/unsub.php");

	$data = unsub($_SESSION["user"]["user_id"]);

	if ($premium == "premium")
	{
		$subscription = $client->subscriptions()->get("" . $data['id_sub'] . "");
		$subscription = $client->subscriptions()->cancel("" . $data['id_sub'] . "");
	}

	header('Location: index.php');
?>