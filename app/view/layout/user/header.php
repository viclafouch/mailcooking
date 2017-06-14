<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?= PAGE_TITLE; ?></title>
		<meta name="description" content="" />
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Lib [CSS]-->
		<link rel="stylesheet" href="lib/css/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="lib/css/jquery-ui/jquery-ui.structure.min.css">
		<?php 
			if ($_GET['action'] == 'email_builder') { ?>
			<link rel="stylesheet" href="lib/css/medium-editor/medium-editor.min.css">
			<link rel="stylesheet" href="lib/css/croppie/croppie-2.4.1.css">
			<link rel="stylesheet" href="lib/css/jquery-minicolors/jquery.minicolors.css">

			<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Lato|Lobster|Montserrat|Open+Sans|Roboto" rel="stylesheet">
		<?php } ?>

		<!-- Custom [CSS]-->
		<link rel="stylesheet" href="webroot/css/custom/back/styles.css">
		<link rel="stylesheet" href="webroot/css/custom/back/fonts.css">

		<!-- A DELETE !-->
		<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>

	  	<!-- Lib [JS]-->
		<script defer src="lib/js/jquery/jquery-3.1.1.min.js"></script>
		<script defer src="lib/js/croppie/croppie-2.4.1.min.js"></script>
		<script defer src="lib/js/html2canvas/html2canvas.js" type="text/javascript"></script>
		<script defer src="lib/js/jquery-ui/jquery-ui.min.js"></script>
		<script defer src="lib/js/jquery-minicolors/jquery.minicolors.min.js"></script>

		<!-- Custom [JS]-->
		<script defer src="webroot/js/script.js"></script>

		<!-- Improve perfs -->
		<script defer src="lib/js/turbolinks/turbolinks.js"></script>
		<meta name="turbolinks-cache-control" content="no-cache">
	</head>

	<body>
		<main class="full_container">
			<aside data-turbolinks-permanent class="sidebar" id="sidebar">
				<header>
					<div id="menu">
						<span></span>
					</div>
					<span class="mymail"><?= $_SESSION["user"]["user_email"]; ?></span>
				</header>
 				<div class="link_container">
	 				<div class="important_links">
	 					<a href="?module=user&action=index" class="noactive" title="">
	 						<p>Accueil</p>
					    	<i class="material-icons">home</i>
					    </a>
					    <a href="?module=user&action=account" class="noactive" title="">
					   		<p>Compte</p>
					     	<i class="material-icons">account_circle</i>
					    </a>
					    <a href="?module=user&action=template" class="noactive" title="">
					    	<p>Template</p>
					    	<i class="material-icons" role="presentation">dashboard</i>
					    </a>
					    <a href="?module=user&action=subs" class="noactive" title="">
					    	<p>Abonnements</p>
					    	<i class="material-icons">stars</i>
					    </a>
					    <?php if ($_SESSION['user']['valide'] == 2): ?>
					    <a href="?module=admin&action=index" class="noactive admin" title="">
					    	<p>Administration</p>
					    	<i class="material-icons">dns</i>
					    </a>
					    <?php endif ?>
	 				</div>
	 				<div class="others_links">
					    <a href="#" class="noactive">
					    	<i class="fa fa-life-ring" aria-hidden="true"></i>
					    </a>
					    <a href="#" class="noactive">
					    	<i class="material-icons">help</i>
					    </a>
					    <a href="?module=user&action=logout" data-turbolinks="false" class="noactive">
					    	<i class="material-icons">directions_run</i>
					    </a>
					</div>
				</div>
			</aside>
			<nav class="nav_top navigation">
				<div class="test"></div>
				<a href="index.php" title=''>
					<img src="webroot/img/logo_mc.png" class="logo" title="" alt=""/>
				</a>
				<form action="#" id="form-search-js" method="post">
					<a href="#" title=""><i class="material-icons">search</i></a>
					<input id="search" onblur="search_blur();" type="text" name="search" placeholder="Rechercher..."/>
				</form>
			</nav>
			<div class="novisible"></div>
			<div class="container">
				<section class="section full-width">      