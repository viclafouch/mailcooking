<?php 

	/**
	 *
	 * Fichier d'affichage du dashboard admin
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

	metadatas('Backoffice', 'Description', 'none');
	
	include_once("app/view/admin/index.php");