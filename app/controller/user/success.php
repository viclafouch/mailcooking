<?php

  if (isset($_SESSION['user_id'])) {
    $id_user = $_SESSION['user_id'];
  }
  else {
    header('Location: index.php');
    exit(0);
  }
	
	if (!isset($_SESSION['flow_id'])) {
		// weird comportement 
		exit(0);
	}
	
	require 'lib/composer/vendor/autoload.php';

$client = new \GoCardlessPro\Client([
	// We recommend storing your access token in an environment variable for security, but you could include it as a string directly in your code
	'access_token' => "sandbox_pvp-IW0V7OWF_qTsgtTsjxuZFSUlDnvjCVMXI1Aw",
	// Change me to LIVE when you're ready to go live
	'environment' => \GoCardlessPro\Environment::SANDBOX
]);

$redirectFlow = $client->redirectFlows()->complete(
  $_SESSION['flow_id'], //The redirect flow ID from above.
  ["params" => ["session_token" => "dummy_session_token"]]
);

print("Mandate: " . $redirectFlow->links->mandate . "<br />"); // to save for payement and follow bank state
// Save this mandate ID for the next section.
print("Customer: " . $redirectFlow->links->customer . "<br />"); // to save

$subscription = $client->subscriptions()->create([
  "params" => [
    "amount" => 6000, // 15 GBP in pence format 6000 = 60.00 € 
    "currency" => "EUR",
    "interval_unit" => "monthly",
    "links" => [
      "mandate" => $redirectFlow->links->mandate
                // Mandate ID from the last section
    ],
    "metadata" => [
      "id_user" => $id_user
    ]
  ],
  "headers" => [
    "Idempotency-Key" => $id_user // id_user
  ]
]);

//$subscription->id; // id subscription to save for cancel sub
unset($_SESSION['flow_id']);

// Insert to bdd
include_once("app/model/user/account/payment/unsub.php");

$success = success($id_user, $redirectFlow->links->customer, $redirectFlow->links->mandate, $subscription->id);