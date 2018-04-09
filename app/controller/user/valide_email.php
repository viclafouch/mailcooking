<?php 

	/**
	 *
	 * Fichier de validation de compte inscrit
	 * CCP : Création de l'ensemble des dossiers du client
	 *
	 */

	/**
	 *
	 * GET obligatoire pour la modification du compte
	 *
	 */

	if (isset($_GET['id'])) {

		include_once('app/model/user/account/signup/validate_email.php');

		$valide_email = valide_email($_GET['id']);
	
	    if ($valide_email) {

	    	include_once('app/model/user/account/read_user.php');

			$read_user = read_user($_GET['id']);

			$id_user = $read_user[0]["user_id"];
			$societe_user = mb_strtolower(substr($read_user[0]["societe"], 0, 3));

			$chemin = "client/".$id_user."_".$societe_user."/";
	    	@mkdir($chemin, 0777, true);
	    	@mkdir($chemin.'commandes', 0777, true);
	    	@mkdir($chemin.'templates', 0777, true);
	    	@mkdir($chemin.'exports', 0777, true);
	    	@mkdir($chemin.'emails', 0777, true);
	    	@mkdir($chemin.'factures', 0777, true);
			
			include_once("app/model/user/account/signin/login.php");

			$user = array(
				user_email => $read_user[0]["user_email"],
				user_password => $read_user[0]["user_password"]
			);

			$token = $_SESSION['token'];
			$key = $_GET['key'];

			if($token && $token === $key){
				include_once("app/model/user/account/signin/autologin.php");
				$checkAdmin = autoLoginAdmin($user);
				$_SESSION["user"] = $checkAdmin;
				location('user', 'index', 'first=1');
			}
			else{
				$checkAdmin = loginAdmin($user);
				$checkUser = loginUser($user);
	
				if ($checkAdmin || $checkUser) {
					
					if ($checkAdmin) { $_SESSION["user"] = $checkAdmin;}
					else { 
						$option = array( 
							'wherecolumn' 	=> 	'user_id',
							'wherevalue'	=>	$checkUser['user_additional_admin_id'],
						);
						
						$user = selecttable('users', $option);
						$_SESSION['user'] = $user[0];
	
						$_SESSION['additional'] = $checkUser;
	
					}
					location('user', 'index', 'first=1');
				}
				else {
					location('home', 'index', "valide=ok");
				}	
			}
	    }
	}

	else {
		die('Il manque ID du user');
	}
