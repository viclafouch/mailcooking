<?php 
	/**
	 *
	 * Fonction de deconnexion/logout au site
	 *
	 */
	
	session_destroy();
	session_unset();
	unset($_SESSION);

	header("Location:./");

	exit;