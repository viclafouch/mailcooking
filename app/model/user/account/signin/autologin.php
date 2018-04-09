<?php 
	function autoLoginAdmin($form)			
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

			$autoLoginAdmin = $query->fetch();
			$query->closeCursor();
		

			if ($autoLoginAdmin) {
				return $autoLoginAdmin;
			}
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}