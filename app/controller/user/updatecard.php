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

    if (isset($_POST['stripeToken'])){
        try {
            $sub = $_SESSION['subscriber']['subscription_id'];
            $cu = \Stripe\Customer::retrieve($_SESSION['subscriber']['customer_id']); // stored in your application
            $cu->source = $_POST['stripeToken']; // obtained with Checkout
            $cu->save();

            $success = "Your card details have been updated!";
        }
            catch(\Stripe\Error\Card $e) {
                // Use the variable $error to save any errors
                // To be displayed to the customer later in the page
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $error = $err['message'];
            }
            // Add additional error handling here as needed
            if (isset($error)) {
                echo $error;
            } elseif (isset($success)) {
                echo $success;
                if($sub = $_SESSION['subscriber']['statut_stripe'] === 'unpaid'){
                    $invoiceObject = \Stripe\Invoice::all(
                        [
                            'subscription' => $sub,
                        ]
                    );

                    $invoice = \Stripe\Invoice::retrieve($invoiceObject ->data[0] -> id);
                    $invoice->closed = false;
                    $invoice->pay();
                }
                location('user', 'account');
            }
    }

	