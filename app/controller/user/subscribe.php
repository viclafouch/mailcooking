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

	if (isset($_POST['stripeToken'])) {

		try {

			$token  = $_POST['stripeToken'];


			/**
			 *
			 * Création d'un client chez Stripe
			 * Attributions de paramètres (facultatifs mais conseillés)
			 * DOC : stripe.com/docs/api#customers
			 *
			 */

			$customer = \Stripe\Customer::create(array(
			 	"description" => 'Société :'.$_SESSION['user']['user_societe'],
				"email" => $_POST['stripeEmail'],
				"metadata" => array(
					"Prénom" => $_SESSION['user']['first_name'], 
					"Nom" => $_SESSION['user']['last_name'],
					"Civilité" => $_SESSION['user']['gender']
				),
				'card'  => $token,
			));


			/**
			 *
			 * Création de l'abonnement chez Stripe
			 * DOC : stripe.com/docs/api#create_subscription
			 *
			 */

			if (isset($_POST['stripePlan'])) {
				$plan = $_POST['stripePlan'];
				if ($plan == 1) {
					$sub = \Stripe\Subscription::create(array(
					  	"customer" => $customer->id,
					  	"plan" => "tip",
					));
					if ($sub) { $validation = 1; } 
					else { die('Une erreur est survenue'); }
				}
				elseif ($plan == 2) {
					$sub = \Stripe\Subscription::create(array(
					  	"customer" => $customer->id,
					  	"plan" => "top",
					));
					if ($sub) { $validation = 2; } 
					else { die('Une erreur est survenue'); }
				}
				elseif ($plan == 3) {
					$sub = \Stripe\Subscription::create(array(
					  	"customer" => $customer->id,
					  	"plan" => "tiptop",
					));
					if ($sub) { $validation = 3; } 
					else { die('Une erreur est survenue'); }
				}
			}

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
			var_dump(get_object_vars($e)['jsonBody']['error']);
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
			die('Une erreur dans le try est survenue');
		}

		/**
		 *
		 * Insertion de l'abonnement en bdd
		 *
		 */

		if ($validation) {
			$id_costumer = $customer->id;
			$id_subscription = $sub->id;
			$id_user = $sessionID;
			$period_end = $sub->current_period_end;

			include_once('app/model/user/account/payment/subscribe.php');
			$subscribe = subscribe($id_user, $id_costumer, $id_subscription, $validation, $period_end);

			if ($subscribe) {
				location('user', 'account', 'plan='.$validation);
			} else {
				die('erreur lors du subscribe');
			}
		} 
	} 

	else {
		var_dump($_POST);
		die('Une erreur est survenue');
	}