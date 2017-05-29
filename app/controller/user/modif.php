<?php
	/*==============================================
	=            Modification d'un user            =
	==============================================*/
	sleep(2);
	if (isset($_POST["first_name"])) {

		try {
			global $connexion;
		  	$query= "UPDATE  users
								SET first_name = :first_name,
								last_name = :last_name,
								societe = :societe,
								nb_phone = :nb_phone
								WHERE user_id = :user_id";

		    $query = $connexion->prepare($query);

		    $query->BindValue(":user_id", 	$_SESSION["user"]["user_id"], 	PDO::PARAM_INT);
		    $query->BindValue(":last_name", $_POST["last_name"],  			PDO::PARAM_STR);
		    $query->BindValue(":first_name",$_POST["first_name"],  			PDO::PARAM_STR);
		    $query->BindValue(":nb_phone",	$_POST["nb_phone"],  			PDO::PARAM_INT);
		    $query->BindValue(":societe", 	$_POST["societe"],  			PDO::PARAM_STR);

		    $query->execute();
		}
		catch ( Exception $e ) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}
	else {
		die();
	}
	
	/*=====  End of Modification d'un user  ======*/