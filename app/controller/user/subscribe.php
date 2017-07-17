<?php

	require_once('app/config/config_stripe.php');

	try {

		$token  = $_POST['stripeToken'];

		$customer = \Stripe\Customer::create(array(
			// Description du user
		 	"description" => 'Société :'.$_SESSION['user']['user_societe'],
		 	// Email du client
			// "email" => strip_tags(trim($_POST['stripeEmail'])),
			"email" => "victor.dlf@outkoo.fr",
			// Metadonnées du client
			"metadata" => array(
				"Prénom" => $_SESSION['user']['first_name'], 
				"Nom" => $_SESSION['user']['last_name'],
				"Civilité" => $_SESSION['user']['gender']
			),
			// Token du client
			'card'  => $token,
		));

		if (isset($_GET['premium'])) {
			$sub = \Stripe\Subscription::create(array(
			  "customer" => $customer->id,
			  "plan" => "testplan",
			));
			$plan = 'prenium';
		}

		$id_costumer = $customer->id;
		$id_subscription = $sub->id;
		$id_user = $sessionID;
		$period_end = $sub->current_period_end;

		include_once('app/model/user/account/payment/subscribe.php');
		subscribe($id_user, $id_costumer, $id_subscription, $plan, $period_end);

		echo "Abonnement validé !";


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
		// Something else happened, completely unrelated to Stripe
	}

