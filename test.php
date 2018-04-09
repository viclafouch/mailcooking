<?php

	/**
	 *
	 * Script serveur s'executant toutes les 24h afin de supprimer
	 * les emails non sauvegardés au moins 1 fois. 
	 * CC : Suppression des emails dont l'etat 'saved' est 0
	 *
	 */

	date_default_timezone_set('Europe/Paris');

	try {
		$dns = 'mysql:host=mc2.c4bpbiq0akz2.us-east-2.rds.amazonaws.com;port=3306;dbname=mc';
        $utilisateur = 'crmcurve999';
        $motDePasse='crmcurve999';

        $options = array (PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

		$connexion = new PDO ($dns, $utilisateur, $motDePasse, $options);
		
		
    } 

    catch (Exception $e) {
        echo "Connexion à MySQL impossible : ", $e->getMessage();
        die();
	}
	
	function test() {
        echo 'bla';
		global $connexion;

		try {
            $query = $connexion->prepare('SELECT * FROM api_available');
            
			$query->execute();
			$result = $query->fetch();

			$query->closeCursor();

            print_r($result);
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
    }
    
    test();

?>