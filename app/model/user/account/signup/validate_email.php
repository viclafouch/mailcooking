<?php 

	function valide_email($id){
		
		global $connexion;

		try {
			
			$query = $connexion->prepare('SELECT * 
											FROM users
												WHERE user_id=:id');

			// On initialise le paramètre
			$query->bindParam(':id', $_GET["id"], PDO::PARAM_INT);

			$query->execute();
			$user = $query->fetchAll();
			$query->closeCursor();

			if ($query->rowCount() == 1) {

				$data = $user;

				if ($user[0]['valide'] == 0) {
					// var_dump($user['valide']);
					try {
						global $connexion;
	  						$query= "UPDATE users
								SET valide = :ok
								WHERE user_id = :user_id";

					    $query = $connexion->prepare($query);

					    $query->BindValue(":user_id", 	$_GET["id"], 	PDO::PARAM_INT);
					    $query->BindValue(":ok", 1,  			PDO::PARAM_STR);

					    $query->execute();
					    $retour = $query;
					    
					    return $query;
					}
					catch ( Exception $e ) {
						die("Erreur SQL : " . $e->getMessage());
					}
				}
				// Account already verif
				else {
					die('Account already verif');
				}
			}
			// ID doesn\'t exists
			else {
				die('ID doesn\'t exists');
			}
		}
		catch ( Exception $e ) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}