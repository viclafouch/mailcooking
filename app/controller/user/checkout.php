<?php

	/**
	 *
	 * Fichier de paiement et d'attribution de plan
	 * Documentation de Stripe : stripe.com/docs
	 * Github : github.com/stripe/stripe-php
	 * Composer requis : github.com/composer/composer
	 *
	 */

	/**
	 *
	 * Fonction de sécurité
	 * Vérification d'une session
	 *
	 */
	
	protec();

	/**
	 *
	 * Le POST est obligatoire 
	 *
	 */

	require_once('app/config/config_stripe.php');

	$options = array( 	
			"wherecolumn"	=>	"user_id",
			"wherevalue"	=>	$sessionID);

	$subscriberOrNot = selecttable("subscribers", $options);

	if (!empty($subscriberOrNot)) {
		$subscriberID = $subscriberOrNot[0]['customer_id'];

		try {

			$token  = $_POST['stripeToken'];

			$customer = \Stripe\Customer::retrieve($subscriberID);

			$charge = \Stripe\Charge::create(array(
			  	"amount" => 20000,
			  	"currency" => "eur",
			  	"customer" => $customer->id,
				"description" => $_POST['nom_commande'],
			));

			if ($charge && $customer) { $validation = true; }


		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];

			print('Status is:' . $e->getHttpStatus() . "\n");
			print('Type is:' . $err['type'] . "\n");
			print('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			print('Param is:' . $err['param'] . "\n");
			print('Message is:' . $err['message'] . "\n");
		} catch (\Stripe\Error\RateLimit $e) {
			echo "Too many requests made to the API too quickly";
			// Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
			echo "Invalid parameters were supplied to Stripe's API";
			// Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
			echo "Authentication with Stripe's API failed";
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
			echo "Network communication with Stripe failed";
			// Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			echo "Display a very generic error to the user, and maybe send";
		} catch (Exception $e) {
			echo "Something else happened, completely unrelated to Stripe";
		}
	}