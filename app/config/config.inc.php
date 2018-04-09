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


	$stripeImg = 'http://www.mailcooking.com/img/mc-stripe.jpg';

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

	//AWS KEYS
	$IAM_KEY = 'AKIAIBWMTNQPZZOLJZPA';
	$IAM_SECRET = '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';
	$bucketName = 'mailcooking';



	$googleFonts = selecttable("google_fonts");

	foreach ($googleFonts as $key => $value) {
		$MC_fontArray[$key] = $value['font_name'];
	}
	
	sort($MC_fontArray);

	$link = 'https://fonts.googleapis.com/css?family=';
	
	foreach ($MC_fontArray as $key => $value) {
		$update_link = $link.str_replace(' ', '+',$value).'%7C';
		$link = $update_link;
	}

	$MC_fonts = substr($link, 0, -3);

	$pathToPublicTemplate = 'template_all/';

	date_default_timezone_set('Europe/Paris');

	// ini_set("SMTP","smtp.gmail.com"); // must be set to your own local ISP
	ini_set( 'smtp_port', '1025' ); // assumes no authentication (passwords) required 
	ini_set( 'sendmail_from', 'fauchet.jeancharles@gmail.com' ); // can be any e-mail address, but must be set

	
	