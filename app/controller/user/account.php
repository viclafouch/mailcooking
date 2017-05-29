<?php 

	protec();

	$options = array( 	"wherecolumn"	=>	"user_id",
						"wherevalue"	=>	$_SESSION["user"]["user_id"]);
	
	$user = selecttable("users", $options);


	metadatas('Mon compte', 'Description', 'none');

	// Appel de la view
	include_once("app/view/user/account.php");

