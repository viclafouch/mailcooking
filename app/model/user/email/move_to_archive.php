<?php
  function move_to_archive($archive, $email_id, $user)
  {
    global $connexion;
      try {
        
        $query= "UPDATE mail_editor
                  SET archive = :archive
                    WHERE id_user = :id_user
                    AND id_mail = :id_mail";

        $query = $connexion->prepare($query);

        $query->BindValue(":archive", $archive,   PDO::PARAM_INT);
        $query->BindValue(":id_mail", $email_id,        PDO::PARAM_STR);
        $query->BindValue(":id_user", $user,            PDO::PARAM_INT);


        // On exécute la requête
        $query->execute();

        return $query;
    }
    catch (Exception $e) {  
      die('Erreur SQL: ' . $e->getMessage());
    }
  }