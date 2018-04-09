<?php

	/**
	 *
	 * Fichier de paiement et de mise à jour de plan
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

	if (isset($_POST['plan'])) {
		
		try {

			/**
			 *
			 * Mise à jour de l'abonnement
			 * DOC : stripe.com/docs/api#retrieve_subscription
			 *
			 */

			// $token  = $_POST['stripeToken'];

			$option = array( 
				'wherecolumn' 	=> 	'user_id',
				'wherevalue'	=>	$sessionID,
			);

			$newPlan = $_POST['plan'];
			$subscription_proration_date = $_POST['plasubscription_proration_daten'];
			// echo 'le plan est '.$newPlan; 

			$sub = selecttable('subscribers', $option);	

			if ($sub) {
				$subscriptionStripe = \Stripe\Subscription::retrieve($sub[0]['subscription_id']);
				
				if ($subscriptionStripe) {
					foreach ($MC_subscriptions as $key => $subscription) {
						if ($newPlan == $subscription['id']) {
							\Stripe\Subscription::update($sub[0]['subscription_id'], [
								'items' => [
									[
										'id' => $subscriptionStripe->items->data[0]->id,
										'plan' => $subscription['StripeID'],
									],
								],
								'proration_date' => $subscription_proration_date,
							]);
						}
					}
				}

				include_once('app/model/user/account/payment/upgrade.php');
				$upgrade = upgrade($sessionID, $newPlan);

				/* Supprime les users additionnels */
				if ($sub[0]['plan'] > $newPlan) {
					include_once('app/model/user/account/payment/delete_users_add.php');
					delete_users($sessionID);
					delete_api($sessionID);
				}

				if ($upgrade) {
					location('user', 'account', 'plan='.$newPlan);
				}
			}
			
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
	} else {
		$err = 'Une erreur a s\'est produite, le paiement a echoué';
	}