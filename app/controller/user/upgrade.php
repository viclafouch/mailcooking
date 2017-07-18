<?php 

	if (!empty($_POST)) {
		require_once('app/config/config_stripe.php');
		try {
			$token  = $_POST['stripeToken'];

			\Stripe\Stripe::setApiKey("sk_test_PS2zQTpRTNObBqwvbCkMtC8p");

			$option = array( 
				'wherecolumn' 	=> 	'user_id',
				'wherevalue'	=>	$sessionID,
			);
			$sub = selecttable('subscribers', $option);	

			$sub_id = $sub[0]['subscription_id'];

			$subscription = \Stripe\Subscription::retrieve($sub_id);

			if ($_POST['plan'] == 1) {
				$subscription->plan = "tip";
			} elseif ($_POST['plan'] == 2) {
				$subscription->plan = "top";
			} elseif ($_POST['plan'] == 3) {
				$subscription->plan = "tiptop";
			}
			
			$subscription->save();

			include_once('app/model/user/account/payment/upgrade.php');
			$upgrade = upgrade($sessionID, $_POST['plan']);

			if ($upgrade) {
				echo "Abonnement mise à jour !";
				sleep(3);
				location('user', 'account');
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
			// Something else happened, completely unrelated to Stripe
		}
	} else {
		die('Une erreur est survenue');
	}