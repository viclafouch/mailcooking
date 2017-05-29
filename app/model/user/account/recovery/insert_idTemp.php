<?php
  function password_forget($id, $email, $time)
  {
    global $connexion;
      try {
        
          $req = "INSERT INTO forgotten_pass (
                              id_unique, 
                              email,
                              timestamp)
                          VALUES (:id_unique,
                                  :email, 
                                  :timestamp)";

          $query = $connexion->prepare($req);

          // On initialise les paramètres
          $query->bindValue(':id_unique', $id, PDO::PARAM_STR);
          $query->bindValue(':email', $email, PDO::PARAM_STR);
          $query->bindValue(':timestamp', $time, PDO::PARAM_STR);


          // On exécute la requête
          $query->execute();

          return $query;
    }
    catch (Exception $e) {  
      die('Erreur SQL: ' . $e->getMessage());
    }
  }