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
                    echo 'updateok';
                    return $query;
                }
                else{
                    $req= "UPDATE users
                    SET user_password = :user_password
                    WHERE user_id = :user_id";

                    $query = $connexion->prepare($req);

                    $query->bindValue(':user_password', $value, PDO::PARAM_STR);
                    $query->bindValue(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);

                    $query->execute();
                    echo 'updateok';
                    return $query;
                }
            }
            elseif($param == 'adress'){
                $req= "UPDATE users
                SET adress = :adress
                WHERE user_id = :user_id";

                $query = $connexion->prepare($req);

                $query->bindValue(':adress', $value, PDO::PARAM_STR);
                $query->bindValue(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);

                $query->execute();
                echo 'updateok';
                return $query;
            }
        }

        catch (Exception $e) {
            die("Erreur SQL : " . $e->getMessage());    
        }
    }