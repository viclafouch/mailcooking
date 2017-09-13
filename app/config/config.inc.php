<?php 

	/**
	 *
	 * Défini la page d'accueil du site
	 * CC : Le module par defaut & l'action par defaut
	 *
	 */

	define("DEFAULT_MODULE", "home");
	define("DEFAULT_ACTION", "index");

	$priceTemplate = 200;
	$currency = '€';
	
	$MC_templateMax = array(
		'1' => 0, 
		'2' => 3,
		'3' => 5,
	);

	$MC_fonts = array(
		'Kaushan Script',
		'Lato',
		'Lobster',
		'Montserrat',
		'Open Sans',
		'Roboto'
	);

	$link = 'https://fonts.googleapis.com/css?family=';
	foreach ($MC_fonts as $key => $value) {
		$update_link = $link.str_replace(' ', '+',$value).'%7C';
		$link = $update_link;
	}

	$MC_fonts = substr($link, 0, -3);