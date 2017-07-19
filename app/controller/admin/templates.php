<?php 

	/**
	 *
	 * Fichier d'affichage des templates
	 *
	 */

	/**
	 *
	 * Fonctions de sécurité
	 * Vérification d'une session
	 * Vérfication du rôle de la session
	 *
	 */
	
	protec();
	just_admin();

	/**
	 *
	 * Affichage de la vue
	 *
	 */
	
	metadatas('Les utilisateurs', 'Description', 'none');

	include_once('app/view/admin/templates.php');