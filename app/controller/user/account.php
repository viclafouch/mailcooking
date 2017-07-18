<?php 

	protec();

	metadatas('Mon compte', 'Description', 'none');

	require_once('app/config/config_stripe.php');

	$option = array( 
			'wherecolumn' 	=> 	'user_id',
			'wherevalue'	=>	$_SESSION["user"]["user_id"],
		);
	$sub = selecttable('subscribers', $option);
	if (count($sub) > 0) {
		$subcription = true;
		$plan = $sub[0]['plan'];
	} else {
		$subcription = false;
	}	

	// Appel de la view
	include_once("app/view/user/account.php");

