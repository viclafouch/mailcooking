<?php
	
	function location($module, $action, $get="") {
		$url = 'Location:?module=' . $module . '&action=' . $action;
		if ($get!="") {
			$url .= "&" .$get;
		}
		else {
			$get = "";
		}
		header($url);
	}

	function upload($index, $maxsize=FALSE, $extensions=FALSE) {
		// Test1: fichier correctement uploadé
		if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) { 
			location('user', 'template', 'notif=noupload'); 
		};

		// Test2: taille limite
		if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) { 
			location('user', 'template', 'notif=nosize'); 
		};

		// Test3: extension
		$ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
		if ($extensions !== FALSE AND !in_array($ext,$extensions)) { 
			location('user', 'template', 'notif=noext'); 
		};
	}
	
	function mail_sender($mail_to, $subject, $message) {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: <'.$mail_to.'>' . "\r\n";
		$headers .= 'From: Mailcooking <norply@mailcooking.com>' . "\r\n";
		return mail($mail_to, $subject, $message,$headers);
	}

	function removeFiles($path) {
		foreach($path as $file) {
			if(is_file($file)) {
			    unlink($file);
			}
		}
	}


	function unzip_file($file, $destination) {
		// Créer l'objet (PHP 5 >= 5.2)
		$zip = new ZipArchive() ;
		// Ouvrir l'archive
		if ($zip->open($file) !== true) {
			return 'Impossible d\'ouvrir l\'archive';
		}
		// Extraire le contenu dans le dossier de destination
		$zip->extractTo($destination);
		// Fermer l'archive
		$zip->close();
		// // Afficher un message de fin
		// die('Archive extrait');
	}