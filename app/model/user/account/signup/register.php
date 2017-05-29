<?php
  function register($user, $hash)
  {
    global $connexion;
      try {
        
        // Vérif si email existe
        $email = $_POST['user_email'];

        $query = $connexion->prepare('SELECT user_email FROM users WHERE user_email = \''.$email.'\';');
        $query->execute(array('.$email.' => $_POST['user_email']));

        $res = $query->fetch();
        if ($res)
        {
            die('deja email enregistré');
        }
        else {

          $req = "INSERT INTO users (
                              user_email, 
                              user_password,
                              first_name,
                              last_name,
                              societe,
                              nb_phone,
                              gender,
                              valide)
                          VALUES (:user_email,
                                  :user_password, 
                                  :first_name, 
                                  :last_name, 
                                  :societe,
                                  :nb_phone,
                                  :gender,
                                  :valide)";

          $query = $connexion->prepare($req);

          // On initialise les paramètres
          $query->bindValue(':user_email', $user["user_email"], PDO::PARAM_STR);
          $query->bindValue(':user_password', $hash, PDO::PARAM_STR);
          $query->bindValue(':first_name', $user["first_name"], PDO::PARAM_STR);
          $query->bindValue(':last_name', $user["last_name"], PDO::PARAM_STR);
          $query->bindValue(':societe', $user["societe"], PDO::PARAM_STR);
          $query->bindValue(':nb_phone', $user["nb_phone"], PDO::PARAM_INT);
          $query->bindValue(':gender', 'male', PDO::PARAM_STR);
          $query->bindValue(':valide', 0, PDO::PARAM_INT);


          // On exécute la requête
          $query->execute();

          return $connexion->LastInsertId();
      }
    }
    catch (Exception $e) {  
      die('Erreur SQL: ' . $e->getMessage());
    }
  }