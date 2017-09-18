<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?= PAGE_TITLE; ?></title>

		<meta name="description" content="" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="turbolinks-cache-control" content="no-cache">
		<meta name="theme-color" content="#f6f6f6">
		<meta name="msapplication-navbutton-color" content="#f6f6f6">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<meta name="twitter:card" content="#" />
		<meta name="twitter:site" content="#" />
		<meta name="twitter:title" content="#" />
		<meta name="twitter:description" content="#" />
		<meta name="twitter:image" content="#" />
		<meta property="og:type" content="#" />
		<meta property="og:title" content="#" />
		<meta property="og:description" content="#" />
		<meta property="og:url" content="#" />
		<meta property="og:site_name" content="#" />
		<meta property="og:image" content="#" />
		<meta property="fb:app_id" content="#" />

   		<link rel="icon" type="image/png" href="favicon.png"/>
   		<link rel="shortcut icon" type="image/x-icon" href="favicon-16x16.png" />
		<link rel="apple-touch-icon" href="icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="icon-retina.png" />
		<link rel="alternate" href="#" hreflang="fr" />
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">		
		<link href="<?= $MC_fonts; ?>" rel="stylesheet">
		<link rel="stylesheet" href="webroot/css/back/min/styles.min.css">

		<script async src="https://checkout.stripe.com/checkout.js"></script>
	</head>
	<body>
		<main>
			<aside data-turbolinks-permanent class="sidebar" id="sidebar">
				<header class="row row-verti-center row-hori-center">
					<div id="menu">
						<span></span>
					</div>
				</header>
 				<div class="link_container">
	 				<div class="important_links col col-hori-center nowrap">
	 					<a href="?module=user&action=index" class="noactive" title="">
	 						<p>Accueil</p>
					    	<i class="material-icons">home</i>
					    </a>
					    <a href="?module=user&action=account" class="noactive" title="">
					   		<p>Compte</p>
					     	<i class="material-icons">account_circle</i>
					    </a>
					    <a href="?module=user&action=emails" class="noactive" title="">
					    	<p>Emails</p>
					    	<i class="material-icons">email</i>
					    </a>
					    <a href="?module=user&action=template" class="noactive" title="">
					    	<p>Template</p>
					    	<i class="material-icons" role="presentation">dashboard</i>
					    </a>
					    <?php if ($_SESSION['user']['valide'] == 2): ?>
					    <a href="?module=admin&action=index" class="noactive admin" title="">
					    	<p>Administration</p>
					    	<i class="material-icons">dns</i>
					    </a>
					    <?php endif ?>
	 				</div>
	 				<div class="others_links col col-hori-center nowrap">
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
			<nav class="navigation row row-verti-center nowrap">
				<a href="index.php" class="logo" title="">
					<img src="webroot/img/logo_mc.png" title="" alt=""/>
				</a>
				<form action="#" id="searchForm" method="post">
					<span><i class="material-icons">search</i></span>
					<input spellcheck="false" autocomplete="off" type="text" name="search" placeholder="Rechercher..."/>
				</form>
			</nav>
			<div class="novisible"></div>
			<div class="large_container">
				<section class="section full-width">
				<div class="popup_mc" id="stoppedSubscription">
					<div class="popup_background"></div>
					<div class="popup_container">
						<header>
							<h1>Votre abonnement</h1>
						</header>
						<form method="post" action="?module=user&action=account">
							<div class="content_block popup-blocks">
								<div>
									<div class="field">
										<div class="oneside aside">
											<label>Nom de l'abonnement :</label>
										</div>
										<div class="overside aside">

											<?php if (isset($_SESSION['subscriber'])): ?>
											<p><?= $_SESSION['subscription']['name']; ?> <i class="material-icons ok">done</i></p>
											<?php else: ?>
											<p>Aucun abonnement <i class="material-icons nok">clear</i></p>
											<?php endif; ?>

										</div>
									</div>
									<div class="field">
										<div class="oneside aside">
											<label>Date du prochain prévèlement :</label>
										</div>
										<div class="overside aside">

											<?php if (isset($_SESSION['subscriber'])): ?>
											<p><?= date('d/m/Y', $_SESSION['subscriber']['date_end_trial']); ?> <i class="material-icons ok">done</i></p>
											<?php else: ?>
											<p>Aucun abonnement <i class="material-icons nok">clear</i></p>
											<?php endif; ?>

										</div>
									</div>
								</div>
							</div>
							<?php if (isset($_SESSION['subscriber'])): ?>
							<footer>
								<button class="button_default button_secondary" id="stopSubscription">Stopper l'abonnement</button>
							</footer>
							<?php endif; ?>
						</form>
					</div>
				</div>      