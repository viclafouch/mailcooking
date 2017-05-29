<?php
  function update_commande($id, $value)
  {
    global $connexion;
      try {
        
        $query= "UPDATE  template_commande
                  SET status = :status
                  WHERE id_commande = :id_commande";

        $query = $connexion->prepare($query);

        $query->BindValue(":id_commande",    $id,    PDO::PARAM_INT);
        $query->BindValue(":status", $value, PDO::PARAM_INT);


        // On exécute la requête
        $query->execute();

        return $query;
    }
    catch (Exception $e) {  
      die('Erreur SQL: ' . $e->getMessage());
    }
  }