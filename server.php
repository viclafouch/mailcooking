<?php

	ini_set('display_errors', '1');

	try 
    {
        // Identifiant & port à compléter
        $dns = 'mysql:host=localhost;port=3306;dbname=crmcu309_mc_2016';
        $utilisateur = 'root';
        $motDePasse='';

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


    function delete_email($id_mail)
	{
		global $connexion;

		try {
			$req = 'DELETE FROM mail_editor
						WHERE id_mail = :id_mail';

			$query = $connexion->prepare($req);

			$query->bindValue(':id_mail', $id_mail, PDO::PARAM_INT);

			$query->execute();
			
		}

		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());		
		}
	}

	function read_email($saved)			
	{
		global $connexion;

		try 
		{
			$query = $connexion->prepare('SELECT * 
											FROM mail_editor
												WHERE saved=:saved');

			$query->bindParam(':saved', $saved, PDO::PARAM_INT);

			$query->execute();
			$emails = $query->fetchAll();
			$query->closeCursor();
			return $emails;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}

	$emailsNotSaved = read_email(0);

	function read_user($user_id)			
	{
		global $connexion;

		try 
		{
			// On voit la requête
			$query = $connexion->prepare('SELECT * 
											FROM users
												WHERE user_id=:user_id');

			// On initialise le paramètre
			$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);

			$query->execute();
			$user = $query->fetchAll();
			$query->closeCursor();

			return $user;
		}
		
		catch (Exception $e) 
		{
			die("Erreur SQL : " . $e->getMessage());
		}
	}

	foreach ($emailsNotSaved as $key => $email) {
		$user = read_user($email['id_user']);
		$societe_user = mb_strtolower(substr($user[0]['societe'], 0, 3));
		$chemin = realpath (__DIR__)."/client/".$email['id_user']."_".$societe_user."/emails/";
		$timestamp = new DateTime($email['timestamp']);
		$email_date = $timestamp->format('d-m-Y');
		$folder = ''.$email['id_mail'].'_'.$email_date.'';
		$path = $chemin.$folder;
		if (file_exists($path)) {
			function removeFiles($path) {
				foreach($path as $file) {
					if(is_file($file)) {
					    unlink($file);
					}
				}
			}
			removeFiles(glob($path.'/*'));
			rmdir($path);
		}
		delete_email($email['id_mail']);
	}

	sleep(10);
?>