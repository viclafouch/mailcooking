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

		} catch(\Stripe\Error\Card $e) {
			$err = 'Card';
		} catch (\Stripe\Error\RateLimit $e) {
			$err = 'RateLimit';
		} catch (\Stripe\Error\InvalidRequest $e) {
			$err = 'InvalidRequest';	
		} catch (\Stripe\Error\Authentication $e) {
			$err = 'Authentication';
		} catch (\Stripe\Error\ApiConnection $e) {
			$err = 'ApiConnection';
		} catch (\Stripe\Error\Base $e) {
			$err = 'Base';
			// Envoyer un email à l'administrateur avec la réponse
		} catch (Exception $e) {
			$err = 'Une erreur a s\'est produite, le paiement a echoué';
		}
	}