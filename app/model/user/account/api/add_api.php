<?php

    function getTableName($router_name){
        global $connexion;

        try {
            // Get table name
            $getTableName = $connexion->prepare('SELECT table_name FROM api_available WHERE router_name=:router_name');
            $getTableName->bindValue(':router_name', $router_name, PDO::PARAM_STR);

            $getTableName -> execute();

            $table_name = $getTableName->fetch(PDO::FETCH_ASSOC)['table_name'];

            return $table_name;
        }
        catch (Exception $e)
        {
          die("Erreur SQL : " . $e->getMessage());
        }
    };


    function checkIfApiExists($table_name, $api_key){
        global $connexion;

        try {
            // Check if this api already exists
            $checkIfApiExists = $connexion->prepare("SELECT *
                                                        FROM $table_name
                                                            WHERE api_key=:api_key");

            $checkIfApiExists->bindValue(':api_key', $api_key, PDO::PARAM_STR);

            $checkIfApiExists->execute();

            $ifExists = $checkIfApiExists->fetchAll(PDO::FETCH_ASSOC);

            return $ifExists;
        }
        catch (Exception $e)
        {
          die("Erreur SQL : " . $e->getMessage());
        }
    }

    function insertInMainTable($user, $router_name){
        global $connexion;

        try {
            $query = $connexion->prepare('INSERT INTO api (user_admin_id, router_name) VALUES (:user,:router_name)');
            $query->bindValue(':user', $user, PDO::PARAM_STR);
            $query->bindValue(':router_name', $router_name, PDO::PARAM_STR);

            $query->execute();

            return $connexion->lastInsertId('api_id');
        }
        catch (Exception $e)
        {
          die("Erreur SQL : " . $e->getMessage());
        }
    }

    function insertInApiTable($table_name, $id, $api_key, $api_secret){
        global $connexion;
        try {
            if(empty($api_secret)){
                $query = $connexion->prepare("INSERT INTO $table_name (api_id, api_key) VALUES (:id, :api_key)");
                $query->bindValue(':id', $id, PDO::PARAM_STR);
                $query->bindValue(':api_key', $api_key, PDO::PARAM_STR);
            }
            else{
                $query = $connexion->prepare("INSERT INTO $table_name (api_id, api_key, api_secret) VALUES (:id, :api_key, :api_secret)");
                $query->bindValue(':id', $id, PDO::PARAM_STR);
                $query->bindValue(':api_key', $api_key, PDO::PARAM_STR);
                $query->bindValue(':api_secret', $api_secret, PDO::PARAM_STR);
            }

            $query->execute();
            return $query;
        }
        catch (Exception $e)
        {
          die("Erreur SQL : " . $e->getMessage());
        }
    }

?>