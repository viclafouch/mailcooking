<?php

	/**
	 *
	 * Script serveur s'executant toutes les 24h afin de supprimer
	 * les emails non sauvegardés au moins 1 fois. 
	 * CC : Suppression des emails dont l'etat 'saved' est 0
	 *
	 */

	date_default_timezone_set('Europe/Paris');

	try {
        $dns = 'mysql:host=localhost;port=3306;dbname=crmcu309_mc_2016';
        $utilisateur = 'root';
        $motDePasse='mysql';

        $options = array (PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        $connexion = new PDO ($dns, $utilisateur, $motDePasse, $options);
    } 

    catch (Exception $e) {
        echo "Connexion à MySQL impossible : ", $e->getMessage();
        die();
    }

    function delete_email($id_mail) {
		global $connexion;

		try {
			$req = 'DELETE FROM mail_editor
						WHERE id_mail = :id_mail';

			$query = $connexion->prepare($req);
			$query->bindValue(':id_mail', $id_mail, PDO::PARAM_INT);
			$query->execute();
			$query->closeCursor();
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}

	function read_email($saved) {
		global $connexion;

		try {
			$query = $connexion->prepare('SELECT * 
											FROM mail_editor
												WHERE saved=:saved');

			$query->bindParam(':saved', $saved, PDO::PARAM_INT);

			$query->execute();
			$emails = $query->fetchAll();
			$query->closeCursor();
			return $emails;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}

	$emailsNotSaved = read_email(0);

	function read_user($user_id) {
		global $connexion;

		try {

			$query = $connexion->prepare('SELECT * 
											FROM users
												WHERE user_id=:user_id');

			$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);

			$query->execute();
			$user = $query->fetchAll();
			$query->closeCursor();

			return $user;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}
	function removeFiles($path) {
		foreach($path as $file) {
			if(is_file($file)) {
				unlink($file);
			}
		}
	}
	foreach ($emailsNotSaved as $key => $email) {
		$user = read_user($email['id_user']);
		$societe_user = mb_strtolower(substr($user[0]['societe'], 0, 3));
		$chemin = realpath (__DIR__)."/client/".$email['id_user']."_".$societe_user."/emails/";
		$timestamp = new DateTime($email['timestamp']);
		$email_date = $timestamp->format('d-m-Y');
		$folder = ''.$email['id_mail'].'_'.$email_date.'';
		$path = $chemin.$folder;
		if (file_exists($path)) {
			removeFiles(glob($path.'/*'));
			rmdir($path);
		}
		delete_email($email['id_mail']);
	}

	require_once('vendor/autoload.php');
	$stripeKeys = array(
	  "secret_key"      => 'sk_test_PS2zQTpRTNObBqwvbCkMtC8p',
	  "publishable_key" => 'pk_test_jdtjz4b05ADqlx5k093fsmgK'
	);
	
	\Stripe\Stripe::setApiKey($stripeKeys['secret_key']);

	$invoices = \Stripe\Charge::all([
	'limit' => 100,
	// 'source[object]' => 'card',
	// 'offset' => 61
	]) -> data;

	usort($invoices, function ($a, $b) {
		if ($a['created'] == $b['created']) {
		   return 0;
	   }
	   return ($a['created'] < $b['created']) ? -1 : 1;
	});

	function checkIfExist($id_stripe){
		global $connexion;

		try {
			$queryPayment = $connexion->prepare('SELECT * 
			FROM payments_stripe
			WHERE id_stripe=:id_stripe');

			$queryPayment->bindParam(':id_stripe', $id_stripe, PDO::PARAM_STR);

			$queryPayment->execute();
			$payment = $queryPayment->fetch(PDO::FETCH_ASSOC);
			$queryPayment->closeCursor();
			return $payment;
		}
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}

	function insertPayment($id_stripe, $amount, $customer_email, $designation, $date_created){
		global $connexion;

		try {
			$query = $connexion->prepare(
				"INSERT INTO payments_stripe (
					id_stripe, 
					amount,
					customer_email,
					designation,
					date_created)

					VALUES (
					:id_stripe, 
					:amount,
					:customer_email,
					:designation,
					:date_created)");
			if(!$designation){
				$designation = 'Abonnement Mailcooking';
			}
			if(!$customer_email){
				$customer_email = '@';
			}

			$date_created = gmdate("Y-m-d\TH:i:s\Z", $date_created);
			
			$query->bindParam(':id_stripe', $id_stripe, PDO::PARAM_STR);
			$query->bindParam(':amount', $amount, PDO::PARAM_STR);
			$query->bindParam(':customer_email', $customer_email, PDO::PARAM_STR);
			$query->bindParam(':designation', $designation, PDO::PARAM_STR);
			$query->bindParam(':date_created', $date_created, PDO::PARAM_STR);

			$query->execute();
		}
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}

	foreach($invoices as $key => $invoice){
	 	if(!checkIfExist($invoice['id'])){
	 		insertPayment($invoice['id'],$invoice['amount']/100,$invoice['receipt_email'],$invoice['metadata']['name'],$invoice['created']);
		}
	};

?>