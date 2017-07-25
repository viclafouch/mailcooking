<?php 
	if (isset($_GET['id']) && isset($_GET['key'])) {

		$option = array( 
			'wherecolumn' 	=> 	'user_additional_id',
			'wherevalue'	=>  $_GET['id']
		);

		$user = selecttable('users_additional', $option);

		if (hash('md5',$user[0]['user_additional_key']) == $_GET['key']) {
			include_once("app/view/home/confirm_user.php");
		}
		else {
			die('Une erreur est survenue');
		}

	}
	else {
		die('Une erreur est survenue');
	}