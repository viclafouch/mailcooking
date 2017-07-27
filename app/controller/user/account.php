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
			$email = $_POST['account'];
			include_once('/app/model/user/account/additional/add_user.php');
			include_once('/app/model/user/account/additional/verif_exist_user.php');

			if (filter_var($email, FILTER_VALIDATE_EMAIL)) { $valide = true; }
	        
			else { header('Content-Type: application/json'); echo json_encode(array('valide' => false,)); return false; }

			if ($valide) {
				$exist = verif_exist_user($email);
				if ($exist > 0) { header('Content-Type: application/json'); echo json_encode(array( 'empty' => false,)); return false; }

			 	$query = $connexion->prepare('SELECT user_email FROM users WHERE user_email = \''.$email.'\';');
      			$query->execute(array('.$email.' => $email));

        		$res = $query->fetch();
        		if ($res) { header('Content-Type: application/json'); echo json_encode(array( 'empty' => false,)); return false; }


				if ($exist > 0) { header('Content-Type: application/json'); echo json_encode(array( 'empty' => false,)); return false; }

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

						if (!$send) {
							header('Content-Type: application/json');
							echo json_encode(array(
							    'send' => false,
							));
							return false;
						}
						echo $add;
					}
				}
			}
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
				if (!$delete) {
					header('Content-Type: application/json');
					echo json_encode(array(
					    'error' => true,
					));
				}
			}
			else {
				header('Content-Type: application/json');
				echo json_encode(array(
				    'error' => true,
				));
			}
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

		elseif (isset($_POST['cancelSubscription'])) {

			if (password_verify($_POST['cancelSubscription'], $_SESSION['user']['user_password'])) {

				$option = array( 
					'wherecolumn' 	=> 	'user_id',
					'wherevalue'	=>	$sessionID,
				);

				$sub = selecttable('subscribers', $option);	

				$sub_id = $sub[0]['subscription_id'];

				if ($sub_id) {

					include_once('/app/model/user/account/payment/cancel.php');
					$cancel_subscription = cancel_subscription($sub_id);
					if ($sub_id) { $validation = true; }
					else { errorAjax('Une erreur s\'est produite'); }
					
					if ($validation) {
						try {
							require_once('app/config/config_stripe.php');
							$subscription = \Stripe\Subscription::retrieve($sub_id);
							$subscription->cancel();
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
					} else { errorAjax('Une erreur s\'est produite'); }
				}

			} else {
				errorAjax('Le mot de passe est incorrect');
			}
		}
	}

	/**
	 *
	 * Affichage de la vue
	 *
	 */


	else {
		metadatas('Mon compte', 'Description', 'none');

		$option = array( 
			'wherecolumn' 	=> 	'user_id',
			'wherevalue'	=>	$sessionID,
		);

		$sub = selecttable('subscribers', $option);

		if (count($sub) > 0) {
			$subcription = true;
			$plan = $sub[0]['plan'];
			if ($plan == 1) {
				$subName = 'Abonnement tip';
			} elseif ($plan == 2) {
				$subName = 'Abonnement top';
			} elseif ($plan == 3) {
				$subName = 'Abonnement tip top';
			}
		} else {
			$subcription = false;
		}	

		$option = array( 
			'wherecolumn' 	=> 	'user_additional_admin_id',
			'wherevalue'	=>	$sessionID,
		);

		$users_additional = selecttable('users_additional', $option);

		/**
		 *
		 * Popup de confirmation d'annulation d'abonnement
		 *
		 */

		if (isset($_GET['popupStopSub'])) { ?>

		<header>
			<h1>Votre abonnement</h1>
		</header>
		<form method="post" action="?module=user&action=account">
			<div class="content_block popup-blocks">
				<div>
					<div class="field">
						<div class="oneside aside">
							<label>Nom de l'abonnement :</label>
						</div>
						<div class="overside aside">
							<?php if ($subcription): ?>
								<p><?= $subName; ?> <i class="material-icons ok">done</i></p>
							<?php else: ?>
								<p>Aucun abonnement <i class="material-icons nok">clear</i></p>
							<?php endif; ?>
						</div>
					</div>
					<div class="field">
						<div class="oneside aside">
							<label>Date du prochain prévèlement :</label>
						</div>
						<div class="overside aside">
							<?php if ($subcription): ?>
								<p><?= date('d/m/Y', $sub[0]['date_end_trial']); ?> <i class="material-icons ok">done</i></p>
							<?php else: ?>
								<p>Aucun abonnement <i class="material-icons nok">clear</i></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php if ($subcription): ?>
			<footer>
				<button class="button_default button_secondary" id="stopSubscription">Stopper l'abonnement</button>
			</footer>
			<?php endif; ?>
		</form>

		<?php } 
		else {
			include_once("app/view/user/account.php");
		}
	}