<?php
	require 'lib/composer/vendor/autoload.php';

	$client = new \GoCardlessPro\Client([
	// We recommend storing your access token in an
	// environment variable for security, but you could
	// include it as a string directly in your code
	'access_token' => "sandbox_pvp-IW0V7OWF_qTsgtTsjxuZFSUlDnvjCVMXI1Aw",
	// Change me to LIVE when you're ready to go live
	'environment' => \GoCardlessPro\Environment::SANDBOX
	]);
	
	$redirectFlow = $client->redirectFlows()->create([
    "params" => [
        "description" => "Mailcooking Abonnement",
                      // This will be shown on the payment pages
        "session_token" => "dummy_session_token",
                      // Not the access token
        "success_redirect_url" => "http://preprod-crmcurve.com/mc2016/success.php"]
    ]);

	$_SESSION['flow_id'] = $redirectFlow->id;
	$customers = $client->customers()->list()->records;
	//print("ID: " . $redirectFlow->id . "<br />");
	//print("URL: " . $redirectFlow->redirect_url);
	//print_r($customers);
	
	header("Location: $redirectFlow->redirect_url");
    //exit();
?>