<?php

	$to = 'jean-charles.fauchet@crmcurve.fr';
	$from = 'contact@mailcooking.io';
	$subject = 'Welcome';
	$message = '<html>';
	$message .= '<font>Bonjour, bienvenue</font>';
	$message .= '</body></html>';

	$headers = "From: " . strip_tags('contact@mailcooking.io') . "\r\n";
	$headers .= "Reply-To: ". strip_tags('contact@mailcooking.io') . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$send = @mail($to, $subject, $message, $headers, "-f " . $from);

?>