<?php
  function update_cat_email($cat_id, $email_id, $user)
  {
    global $connexion;
      try {
        
        $query= "UPDATE  mail_editor
                  SET cat_id = :cat_id
                    WHERE id_user = :id_user
                    AND id_mail = :id_mail";

        $query = $connexion->prepare($query);

        $query->BindValue(":cat_id",  $cat_id,   PDO::PARAM_INT);
        $query->BindValue(":id_mail", $email_id, PDO::PARAM_STR);
        $query->BindValue(":id_user", $user, PDO::PARAM_INT);


        // On exécute la requête
        $query->execute();

        return $query;
    }
    catch (Exception $e) {  
      die('Erreur SQL: ' . $e->getMessage());
    }
  }