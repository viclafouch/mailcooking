<?php 

	function password($email)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM users
												WHERE user_email=:email');

			// On initialise le paramètre
			$query->bindParam(':email', $email, PDO::PARAM_STR);

			$query->execute();
			$var = $query->fetch();
			$query->closeCursor();

			return $var;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}
