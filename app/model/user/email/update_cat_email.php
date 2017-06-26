<?php
  function update_cat_email($email_cat_id, $id_mail, $id_user)
  {
    global $connexion;
      try {
        
        $query= "UPDATE mail_editor
                  SET email_cat_id = :email_cat_id
                    WHERE id_user = :id_user
                    AND id_mail = :id_mail";

        $query = $connexion->prepare($query);

        $query->BindValue(":email_cat_id",  $email_cat_id,   PDO::PARAM_INT);
        $query->BindValue(":id_mail", $id_mail, PDO::PARAM_STR);
        $query->BindValue(":id_user", $id_user, PDO::PARAM_INT);


        // On exécute la requête
        $query->execute();

        return $query;
    }
    catch (Exception $e) {  
      die('Erreur SQL: ' . $e->getMessage());
    }
  }