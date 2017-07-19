<?php 

	/**
	 *
	 * Fichier d'affichage des utilisateurs
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
	 * Envoie des données pour la lecture des utilisateurs
	 *
	 */
	
	$users = selecttable('users',
				array('orderby' => 'timestamp',
					'order' => 'DESC',
			));

	$nb_users = counttable("users");

	metadatas('Les utilisateurs', 'Description', 'none');

	include_once('app/view/admin/users.php');