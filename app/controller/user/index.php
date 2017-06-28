<?php 

	include_once('app/model/user/email/read_limit_emails.php');

	$emails = read_limit_email($sessionID, 0);
	
	metadatas('Mes emails', 'Description', 'none');

	include_once("app/view/user/index.php");