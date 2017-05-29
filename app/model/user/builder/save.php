<?php

  function save($title, $dom, $background, $id, $user)   
  {
    global $connexion;

    try 
    {
      // On voit la requête
      $query = $connexion->prepare('UPDATE  mail_editor
              SET email_name = :email_name,
              email_dom = :email_dom,
              email_background = :email_background
                WHERE id_mail = :id_mail
                AND id_user = :id_user');

      // On initialise le paramètre
      $query->BindValue(":email_name",    $title,    PDO::PARAM_STR);
      $query->BindValue(":email_dom",    $dom,    PDO::PARAM_STR);
      $query->BindValue(":email_background",    $background,    PDO::PARAM_STR);
      $query->BindValue(":id_mail",    $id,    PDO::PARAM_STR);
      $query->BindValue(":id_user", $user, PDO::PARAM_STR);

      $query->execute();
      $query->closeCursor();

      return $query;
    }
    
    catch (Exception $e) 
    {
      die("Erreur SQL : " . $e->getMessage());
    }
  }