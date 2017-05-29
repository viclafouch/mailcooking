<?php 

	function protec() {
		if (!isset($_SESSION["user"])) {
			location('home', 'index', '');
		}
		else {
			if ($_SESSION["user"]["valide"] == 0) {
				die('vous devez confirmé votre compte !');
			}
		}
	}

	function just_admin() {
		if ($_SESSION["user"]["valide"] < 2) {
			die();
		}
	}

	// verif if param
	function secu($param) {
		if (!isset($_GET[$param])) {
		 	location('home', 'index', 'erreur=param');
		}
	}