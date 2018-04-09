<?php 
	/**
	 *
	 * Fonction de deconnexion/logout au site
	 *
	 */
	
	session_destroy();
	session_unset();
	unset($_SESSION);
	// unset($_COOKIE);
	header("Location:./");

	exit;