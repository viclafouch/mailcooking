<?php 
	// Need the id (forgotten pass table)
	if(!isset($_GET['id'])) {
		die('manque l\'id dans les param');
	}
	else {

		if (isset($_POST['password1']) && isset($_POST['password2'])) {

			include_once('app/model/user/account/recovery/read_idTemp.php');

			$data = read_idTemp($_GET["id"]);
			// var_dump($data);

			if ($_POST['password1'] == $_POST['password2']) {
				$hash = password_hash($_POST['password1'], PASSWORD_DEFAULT);

				include_once('app/model/user/account/recovery/update_password.php');

				$update = update_password($hash, $data["email"]);

				if($update) {

					include_once('app/model/user/account/recovery/delete_idTemp.php');

					$delete = delete_row_forgotten_pass($data["email"]);

					if ($delete) {
						die('pass updated');
					}
				}
			}
			else {
				die('mdp pas identiques');
			}
		}
		else {
			include_once('app/view/home/recovery_password.php');
		}
	}