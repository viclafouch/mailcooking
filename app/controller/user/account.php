<?php 
	/**
	 *
	 * Fichier d'affichage de la page profil
	 *
	 */

	/**
	 *
	 * Fonction de sécurité
	 * Vérification d'une session
	 *
	 */

	protec();

	/**
	 *
	 * Affichage de la vue
	 * Envoi des données pour connaitre si client ou non
	 *
	 */

	if (!empty($_POST)) {

		/**
		 *
		 * Fonction d'ajout d'utilisateur au compte
		 * CCP : Retourne un email de demande de validation
		 *
		 */

		if (isset($_POST['account'])) {

			if (isset($_SESSION['subscriber'])) {


				$option = array( 
					'wherecolumn' 	=> 	'user_additional_admin_id',
					'wherevalue'	=>	$sessionID,
				);

				$users = selecttable('users_additional', $option);

				if (count($users) >= $_SESSION['subscription']['users']) {
					errorAjax('Vous avez atteint le nombre max d\'utilisateurs'); 
					return false;
				}

				$email = $_POST['account'];
				include_once('/app/model/user/account/additional/add_user.php');
				include_once('/app/model/user/account/additional/verif_exist_user.php');

				if (filter_var($email, FILTER_VALIDATE_EMAIL)) { $valide = true; }
		        
				else { errorAjax('Veuillez respecter le format requis'); return false; }

				if ($valide) {
					$exist = verif_exist_user($email);

				 	$query = $connexion->prepare('SELECT user_email FROM users WHERE user_email = \''.$email.'\';');
	      			$query->execute(array('.$email.' => $email));

	        		$res = $query->fetch();
	        		if ($exist > 0 || $res) { errorAjax('L\'adresse email existe déjà');  return false; }

					else {
						$key = uniqid();
						$add = add_user($sessionID, $email, $key);

						if ($add) {
							$to = $email;
							$from = 'victor.dlf@outlook.fr';
							$subject = "Création de votre compte MailCooking par ".$_SESSION['user']["first_name"]." ".$_SESSION['user']["last_name"];
							$message = '<html><body color="#000">';
							$message .= '<h3>Veuillez confirmer votre compte et créer votre mot de passe</h3>';
							$message .= '<a href="http://localhost/mailcooking/?module=home&action=confirm_user&id='.$add.'&key='.hash('md5', $key).'">http://localhost/mailcooking/?module=home&action=confirm_user&id='.$add.'&key='.hash('md5', $key).'</a>';
							$message .= '</body></html>';

							$headers = "From: " . strip_tags('mailcooking.noreply@mailcooking.fr') . "\r\n";
							$headers .= "Reply-To: ". strip_tags('victor.dlf@outlook.fr') . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							$send = @mail($to, $subject, $message, $headers, "-f " . $from);

							if (!$send) { errorAjax('Une erreur est survenue'); return false; }
						}
					}
				}
			} else { errorAjax('Un abonnement est requis'); return false; }
		}

		/**
		 *
		 * Fonction de suppression de user additionnel
		 *
		 */

		elseif (isset($_POST['idAccount'])) {
			$id = $_POST['idAccount'];

			include_once('/app/model/user/account/additional/delete_user.php');

			$option = array( 
				'wherecolumn' 	=> 	'user_additional_id',
				'wherevalue'	=>	$id,
			);

			$user = selecttable('users_additional', $option);
			if ($user[0]['user_additional_admin_id'] == $sessionID) {
				$delete = delete_user($id);
				if (!$delete) { errorAjax('Une erreur est survenue'); return false; }
			}
			else { errorAjax('Une erreur est survenue'); return false; }
		}

		/**
		 *
		 * Fonction de modification de mot de passe
		 *
		 */

		elseif (isset($_POST['password'])) {
			include_once('/app/model/user/account/modif.php');
			$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$update = update_user('password', $hash);
			if (!$update) { errorAjax(); }
		}

		/**
		 *
		 * Fonction d'annulation de son abonnement
		 *
		 */

		elseif (isset($_POST['cancelSubscription'], $_SESSION['subscriber']['subscription_id'])) {

			if (password_verify($_POST['cancelSubscription'], $_SESSION['user']['user_password'])) {

				try {
					$subscription = \Stripe\Subscription::retrieve($_SESSION['subscriber']['subscription_id']);
					$subscription->cancel();
					include_once('/app/model/user/account/payment/cancel.php');
					$cancel_subscription = cancel_subscription($_SESSION['subscriber']['subscription_id']);
					unset($_SESSION['subscriber'], $_SESSION['subscription']);
				} 
				catch(\Stripe\Error\Card $e) {
					errorAjax('Une erreur s\'est produite');
				} catch (\Stripe\Error\RateLimit $e) {
					errorAjax('Une erreur s\'est produite');
				} catch (\Stripe\Error\InvalidRequest $e) {
					errorAjax('Une erreur s\'est produite');
				} catch (\Stripe\Error\Authentication $e) {
					errorAjax('Une erreur s\'est produite');
				} catch (\Stripe\Error\ApiConnection $e) {
					errorAjax('Une erreur s\'est produite');
				} catch (\Stripe\Error\Base $e) {
					errorAjax('Une erreur s\'est produite');
				} catch (Exception $e) {
					errorAjax('Une erreur s\'est produite');
				}
			} else {
				errorAjax('Le mot de passe est incorrect');
			}
		}
	}

	/**
	 *
	 * Affichage de popup Stripe
	 *
	 */

	elseif (isset($_GET['booking_id'])) {

		foreach ($MC_subscriptions as $key => $subscription) {
			if ($_GET['booking_id'] == $subscription['id']) {
				$data = [
				    'key' => $stripeKeys['publishable_key'],
				    'image' => 'https://stripe.com/img/documentation/checkout/marketplace.png',
				    'locale' => 'auto',
				    'name' => $appName,
				    'zipCode' => true,
				    'currency' => 'EUR',
				    'description' => $subscription['name'] .' - 1 mois',
				    'amount' => $subscription['price'] * 100,
				];
			}
		}

		echo json_encode($data);
		return;
	
	}

	/**
	 *
	 * Affichage de la vue
	 *
	 */

	else {
		metadatas('Mon compte', 'Description', 'none');	

		$option = array( 
			'wherecolumn' 	=> 	'user_additional_admin_id',
			'wherevalue'	=>	$sessionID,
		);

		$users_additional = selecttable('users_additional', $option);

		include_once("app/view/user/account.php");
	}