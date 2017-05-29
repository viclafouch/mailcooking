<?php
  function success($id, $costumer, $mandate, $sub)
  {
    global $connexion;
      try {

          $req = "INSERT INTO pay_history (
                              id_user, 
                              id_costumer,
                              id_mandate,
                              id_sub,
                              status_mendate,
                              status_sub,
                              timestamp_payement)
                          VALUES (:id_user,
                                  :id_costumer, 
                                  :id_mandate, 
                                  :id_sub, 
                                  :status_mendate,
                                  :status_sub,
                                  :timestamp_payement)";

          $query = $connexion->prepare($req);

          // On initialise les paramètres
          $query->bindValue(':id_user', $id, PDO::PARAM_STR);
          $query->bindValue(':id_costumer', $costumer, PDO::PARAM_STR);
          $query->bindValue(':id_mandate', $mandate, PDO::PARAM_STR);
          $query->bindValue(':id_sub', $sub, PDO::PARAM_STR);
          $query->bindValue(':status_mendate', '', PDO::PARAM_STR);
          $query->bindValue(':status_sub', '', PDO::PARAM_INT);
          $query->bindValue(':timestamp_payement', time(), PDO::PARAM_INT);


          // On exécute la requête
          $query->execute();

          return $query;
      }
    }
    catch (Exception $e) {  
      die('Erreur SQL: ' . $e->getMessage());
    }
  }