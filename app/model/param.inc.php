<?php 
    try 
    {
        // Identifiant & port à compléter
        $dns = 'mysql:host=localhost;port=3306;dbname=crmcu309_mc_2016';
        $utilisateur = 'root';
        $motDePasse='mysql';

        // Option de connexion
        $options = array (PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        // Initialisation de la varible avec ma connexion PDO
        $connexion = new PDO ($dns, $utilisateur, $motDePasse, $options);
    }
    catch (Exception $e)
    {
        echo "Connexion à MySQL impossible : ", $e->getMessage();
        die();
    }