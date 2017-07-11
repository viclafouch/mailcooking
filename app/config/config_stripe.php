<?php
	require_once('vendor/autoload.php');

	$stripe = array(
	  "secret_key"      => getenv('sk_test_PS2zQTpRTNObBqwvbCkMtC8p'),
	  "publishable_key" => getenv('pk_test_jdtjz4b05ADqlx5k093fsmgK')
	);

	\Stripe\Stripe::setApiKey("sk_test_PS2zQTpRTNObBqwvbCkMtC8p");
?>