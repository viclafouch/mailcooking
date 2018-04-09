<?php

  function save($title, $dom, $background, $id, $saved, $savedby, $user)   
  {
    global $connexion;

    try {
      $query = $connexion->prepare('UPDATE  mail_editor
              SET email_name = :email_name,
              email_dom = :email_dom,
              email_background = :email_background,
              saved = :saved,
              saved_by =:savedby
              WHERE id_mail = :id_mail
              AND id_user = :id_user');

      $query->BindValue(":email_name",    $title,    PDO::PARAM_STR);
      $query->BindValue(":email_dom",    $dom,    PDO::PARAM_STR);
      $query->BindValue(":email_background",    $background,    PDO::PARAM_STR);
      $query->BindValue(":saved",    $saved,    PDO::PARAM_INT);
      $query->BindValue(":savedby",    $savedby,    PDO::PARAM_STR);
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
  };

  function set_as_campaign($id, $as_campaign, $export_type)   
  {
    global $connexion;

    try {
      $query = $connexion->prepare('UPDATE  mail_editor
              SET as_campaign = :as_campaign,
              export_type = :export_type,
              date_export = NOW()
              WHERE id_mail = :id_mail');


      $query->BindValue(":as_campaign", $as_campaign, PDO::PARAM_INT);
      $query->BindValue(":export_type", $export_type, PDO::PARAM_STR);
      $query->BindValue(":id_mail", $id, PDO::PARAM_INT);

      $query->execute();
      $query->closeCursor();

      return $query;
    }
    
    catch (Exception $e)
    {
      die("Erreur SQL : " . $e->getMessage());
    }
  }