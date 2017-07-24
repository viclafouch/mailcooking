<?php 

	function loginAdmin($form)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM users
												WHERE user_email=:user_email');

			$query->bindParam(':user_email', $form["user_email"], PDO::PARAM_STR);

			$query->execute();

			$loginAdmin = $query->fetch();
			$query->closeCursor();

			if ($loginAdmin && password_verify($_POST['user_password'],$loginAdmin['user_password'])) {
				return $loginAdmin;
			}
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}

	function loginUser($form)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM users_additional
												WHERE user_additional_email=:user_additional_email');

			$query->bindParam(':user_additional_email', $form["user_email"], PDO::PARAM_STR);

			$query->execute();

			$loginUser = $query->fetch();
			$query->closeCursor();

			if ($loginUser && password_verify($_POST['user_password'],$loginUser['user_additional_password'])) {
				return $loginUser;
			}
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}