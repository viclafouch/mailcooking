<?php


	/**
	 *
	 * Documentation de Stripe : stripe.com/docs
	 * Github : github.com/stripe/stripe-php
	 * Composer requis : github.com/composer/composer
	 *
	 */
	
	require_once('vendor/autoload.php');

	/**
	 *
	 * Les clefs requises pour contacter l'API
	 * A modifier lors de la mise en ligne de Mailcooking
	 * Ce sont actuellement des clefs de test
	 *
	 */
	

	$stripe = array(
	  "secret_key"      => getenv('sk_test_PS2zQTpRTNObBqwvbCkMtC8p'),
	  "publishable_key" => getenv('pk_test_jdtjz4b05ADqlx5k093fsmgK')
	);

	\Stripe\Stripe::setApiKey("sk_test_PS2zQTpRTNObBqwvbCkMtC8p");
?>