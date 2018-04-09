<?php 
	if (isset($_GET['id']) && isset($_GET['key'])) {

		$option = array( 
			'wherecolumn' 	=> 	'user_additional_id',
			'wherevalue'	=>  $_GET['id']
		);

		$user = selecttable('users_additional', $option);

		if ($user[0]['statut'] == 0) {
			if (hash('md5',$user[0]['user_additional_key']) == $_GET['key']) {
				if (!empty($_POST) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['firstname']) && isset($_POST['lastname'])) {
					if ($_POST['password1'] == $_POST['password2']) {
						include_once('/app/model/user/account/additional/add_user.php');
						$hash = password_hash($_POST['password1'], PASSWORD_DEFAULT);

						if (is_string($_POST['firstname']) && is_string($_POST['lastname'])) {
							$valide = valide_user_add($_GET['id'], $hash, $_POST['firstname'], $_POST['lastname'],  1);

							if ($valide) {
								$to = $user[0]['user_additional_email'];
								$from = 'victor.dlf@outlook.fr';
								$subject = "Bienvenue dans votre compte Mailcooking !";
								$message = '<html><body color="#000">';
								$message .= '<p>Vous venez d\'activer votre compte Mailcooking et nous vous en remercions.</p>';
								$message .= '<p>Nous vous rappelons votre identifiant : '.$user[0]['user_additional_email'].'.</p>';
								$message .= '<p>Vous seul connaissez votre mot de passe.</p>';
								$message .= '<p><a href="http://localhost/mailcooking/?module=home&action=index">Accéder à votre compte</a></p>';
								$message .= '<p>L\'équipe Mailcooking.</p>';
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

								$userLog = array(
									user_email => $user[0]["user_additional_email"],
									user_password => $_POST['password1']
								);

								include_once("app/model/user/account/signin/login.php");

								$checkUser = loginUser($userLog);
					
								if ($checkUser) {
									$option = array( 
										'wherecolumn' 	=> 	'user_id',
										'wherevalue'	=>	$checkUser['user_additional_admin_id'],
									);
									
									$userLog = selecttable('users', $option);
									$_SESSION['user'] = $checkUser;

									$_SESSION['additional'] = $checkUser;

									location('user', 'index');
								}
								else {
									location('home', 'index', "valide=ok");
								}
							}
						}
						else {
							die('Merci de respecter le format des différents champs');
						}
					}
					else {
						die('Mots de passes non identique');
					}
				} 
				else {
					include_once("app/view/home/confirm_user.php");
				}
			}
			else {
				die('Une erreur est survenue');
			}
		}
		else {
			die('Votre compte est déjà validé');
		}
	}
	else {
		die('Une erreur est survenue');
	}