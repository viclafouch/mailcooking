<?php 

    function update_user($param, $value) {

        global $connexion;
        try {
            if ($param == 'password') {
                if (isset($_SESSION['additional'])) {
                    $req= "UPDATE users_additional
                    SET user_additional_password = :user_additional_password
                        WHERE user_additional_id = :user_additional_id";

                    $query = $connexion->prepare($req);

                    $query->bindValue(':user_additional_password', $value, PDO::PARAM_STR);
                    $query->bindValue(':user_additional_id', $_SESSION['additional']['user_additional_id'], PDO::PARAM_INT);

                    $query->execute();
                    return $query;
                }
            }
        }

        catch (Exception $e) {
            die("Erreur SQL : " . $e->getMessage());    
        }
    }