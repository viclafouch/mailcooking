<?php

	/**
	 *
	 * Fichier d'affichage du dashobard user
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
	 *
	 */

	include_once('app/model/user/email/read_limit_emails.php');
	$emails = read_limit_email($sessionID, 0);


	include_once('app/model/user/template/count_templates.php');
	$TPerso = countTemplates($sessionID, 1);
	$tPublic = countTemplates('all', 1);	

	include_once('app/model/user/email/countEmail.php');
	$Eperso = countEmails($sessionID, 1, 0);

	$totalP = $TPerso + $tPublic; 
	
	metadatas('Mes emails', 'Description', 'none');

	include_once("app/view/user/index.php");