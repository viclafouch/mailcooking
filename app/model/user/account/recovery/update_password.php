<?php

  function update_password($password, $email)   
  {
    global $connexion;

    try 
    {
      // On voit la requête
      $query = $connexion->prepare('UPDATE  users
              SET user_password = :user_password
                WHERE user_email = :user_email');

      // On initialise le paramètre
      $query->BindValue(":user_email",    $email,    PDO::PARAM_STR);
      $query->BindValue(":user_password", $password, PDO::PARAM_STR);

      $query->execute();
      $query->closeCursor();

      return $query;
    }
    
    catch (Exception $e) 
    {
      die("Erreur SQL : " . $e->getMessage());
    }
  }