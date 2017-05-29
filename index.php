<?php

	session_start();

	if (isset($_SESSION['user'])) {
		$id_user = $_SESSION['user']["user_id"];
		$societe_user = mb_strtolower(substr($_SESSION['user']["societe"], 0, 3));

		// Add folders
		$chemin = "client/".$id_user."_".$societe_user."/";
		// die($chemin);
	}
	
	// Connexion à la base de données
	include_once("app/model/param.inc.php");

	// Config
	include_once("app/config/config.inc.php");

	// Securités
	include_once("core/coresecu.php");

	// Location /
	include_once("core/corecontroller.php");

	// Metadatas
	include_once("core/coreview.php");

	// Selecttable /
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
		die("Erreur 404 !!!");	
	}
