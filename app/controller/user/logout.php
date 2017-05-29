<?php 
	session_destroy();
	session_unset();
	unset($_SESSION);

	header("Location:index.php");
	exit;