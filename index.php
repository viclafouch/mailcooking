<?php

	session_start();

	/**
	 *
	 * Récupération du dossier client selon la session
	 *
	 */
	
	if (isset($_SESSION['user'])) {
		
		$sessionID = $_SESSION['user']['user_id'];

		$id_user = $_SESSION['user']["user_id"];
		$societe_user = mb_strtolower(substr($_SESSION['user']["societe"], 0, 3));
		$chemin = "client/".$id_user."_".$societe_user."/";

	}
	
	// Connexion à la base de données
	include_once("app/model/param.inc.php");

	// Config
	include_once("app/config/config.inc.php");

	// Securités
	include_once("core/coresecu.php");

	// Location / Upload / Mail sender / Remove files / Unzip files
	include_once("core/corecontroller.php");

	// Metadatas
	include_once("core/coreview.php");

	// Selecttable / Counttable
	include_once("core/coremodel.php");

	// Appel du controleur et du module demandé
	if (!isset($_GET['module'])) {
		$module = DEFAULT_MODULE;
	} else {
		$module = $_GET['module'];
	}
	if (!isset($_GET['action'])) {
		$action = DEFAULT_ACTION;
	} else {
		$action = $_GET['action'];
	}

	$url = "app/controller/" . $module . "/" . $action . ".php";
	if(file_exists($url)) {
		include_once("$url");
	}
	else { 
		die("Page not found");	
	}
