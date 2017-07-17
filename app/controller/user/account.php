<?php 

	protec();

	metadatas('Mon compte', 'Description', 'none');

	require_once('app/config/config_stripe.php');

	// Appel de la view
	include_once("app/view/user/account.php");

