<?php

	require_once('vendor/autoload.php');

	/**
	 *
	 * Défini la page d'accueil du site
	 * CC : Le module par defaut & l'action par defaut
	 *
	 */

	$appName = 'Mailcooking';

	define("DEFAULT_MODULE", "home");
	define("DEFAULT_ACTION", "index");

	$priceTemplate = 200;
	$currency = '€';

	$stripeKeys = array(
	  "secret_key"      => 'sk_test_PS2zQTpRTNObBqwvbCkMtC8p',
	  "publishable_key" => 'pk_test_jdtjz4b05ADqlx5k093fsmgK'
	);

	$stripeImg = 'https://stripe.com/img/documentation/checkout/marketplace.png';

	\Stripe\Stripe::setApiKey($stripeKeys['secret_key']);

	$MC_subscriptions = array (
		$MC_ftSub = array(
			'id' => 1,
			'price' => 48,
			'name' => 'Abonnement tip',
			'publicModels' => true,
			'users' => 1,
			'privateTemplate' => false,
			'implementCode' => false,
			'API' => false,
			'advice' => false,
			'StripeID' => 'tip',
		),

		$MC_SdSub = array(
			'id' => 2,
			'price' => 72,
			'name' => 'Abonnement top',
			'publicModels' => true,
			'users' => 3,
			'privateTemplate' => 3,
			'implementCode' => false,
			'API' => 1,
			'advice' => false,
			'StripeID' => 'top',
		),

		$MC_TdSub = array(
			'id' => 3,
			'price' => 108,
			'name' => 'Abonnement tip top',
			'publicModels' => true,
			'users' => 100,
			'privateTemplate' => 5,
			'implementCode' => true,
			'API' => 10,
			'advice' => true,
			'StripeID' => 'tiptop',
		)
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

	$pathToPublicTemplate = 'template_all/';