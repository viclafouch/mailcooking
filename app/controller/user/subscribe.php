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
	
	protec();

	if (isset($_POST['stripeToken'])) {

		require_once('app/config/config_stripe.php');

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
			 * /! La méthode GET n'est pas super, à changer de facon pour choisir le plan !\
			 *
			 */

			if (isset($_GET['tip'])) {
				$sub = \Stripe\Subscription::create(array(
				  "customer" => $customer->id,
				  "plan" => "tip",
				));
				if ($sub) {
					$plan = 1;
				}
				
			} elseif (isset($_GET['top'])) {
				$sub = \Stripe\Subscription::create(array(
				  "customer" => $customer->id,
				  "plan" => "top",
				));
				if ($sub) {
					$plan = 2;
				}
			} elseif (isset($_GET['tiptop'])) {
				$sub = \Stripe\Subscription::create(array(
				  "customer" => $customer->id,
				  "plan" => "tiptop",
				));
				if ($sub) {
					$plan = 3;
				}
			}

			/**
			 *
			 * Insertion de l'abonnement en bdd
			 *
			 */

			if ($plan) {
				$id_costumer = $customer->id;
				$id_subscription = $sub->id;
				$id_user = $sessionID;
				$period_end = $sub->current_period_end;

				include_once('app/model/user/account/payment/subscribe.php');
				$subscribe = subscribe($id_user, $id_costumer, $id_subscription, $plan, $period_end);

				if ($subscribe) {
					location('user', 'account', 'plan='.$plan);
				} else {
					die('erreur lors du subscribe');
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
	} 
	else {
		die('Une erreur est survenue');
	}