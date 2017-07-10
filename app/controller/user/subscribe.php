<?php 

	require '/vendor/autoload.php';

	// Set your secret key: remember to change this to your live secret key in production
	// See your keys here: https://dashboard.stripe.com/account/apikeys
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
	\Stripe\Stripe::setApiKey("sk_test_PS2zQTpRTNObBqwvbCkMtC8p");

	// Token is created using Stripe.js or Checkout!
	// Get the payment token submitted by the form:
	$token = $_POST['stripeToken'];

	// Charge the user's card:
	$plan = \Stripe\Plan::create(array(
	  "name" => "Basic Plan",
	  "id" => $token,
	  "interval" => "month",
	  "currency" => "usd",
	  "amount" => 0,
	));

	$customer = \Stripe\Customer::create(array(
	  "email" => "jenny.rosen@example.com",
	));

	\Stripe\Subscription::create(array(
	  "customer" => $customer->$sessionID,
	  "plan" => "basic-monthly",
	));