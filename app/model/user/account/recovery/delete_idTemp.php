<?php 

	function delete_row_forgotten_pass($email)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('DELETE FROM forgotten_pass
												WHERE email=:email');

			// On initialise le paramètre
			$query->bindParam(':email', $email, PDO::PARAM_STR);

			$query->execute();

			return $query;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}
