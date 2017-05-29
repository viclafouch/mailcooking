<?php 

	function login($form)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM users
												WHERE user_email=:user_email');

			// On initialise les paramètres
			$query->bindParam(':user_email', $form["user_email"], PDO::PARAM_STR);
			// $query->bindParam(':user_password', $form["user_password"], PDO::PARAM_STR);

			// On exécute la requête
			$query->execute();

			// On récupère tous les résultats
			$users = $query->fetch();
			$query->closeCursor();

			if (password_verify($_POST['user_password'],$users['user_password'])) {
				return $users;
			} else {
				die('wrong password');
			}
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}