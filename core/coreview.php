<?php 

	function metadatas ($title, $descr, $robots) {

		if (isset($title)){
			$MonTitre = substr($title, 0, 60). ' ' . '|  MailCooking';
			$MonTitre = htmlspecialchars($MonTitre);
			define("PAGE_TITLE", $MonTitre);
		}
		else {
			define("PAGE_TITLE", "Pas de titre");
		}

		if (isset($descr)){
			$MaDescription = substr($descr, 0, 160);
			$MaDescription = htmlspecialchars($MaDescription);
			define("PAGE_DESCRIPTION", $MaDescription .'...');
		}
		else {
			define("PAGE_DESCRIPTION", "Pas de description");
		}
		
		if (isset($robots)) {
			define("PAGE_ROBOTS", $robots);
		}
		else {
			define("PAGE_ROBOTS", "none");
		}
	}