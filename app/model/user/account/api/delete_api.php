<?php 
	function delete_api($api_id){
		global $connexion;

		try {
			$sql = "SELECT router_name FROM api
										 WHERE api_id=".$api_id;
			
			$queryroutername = $connexion->query($sql);
			$router_name = $queryroutername -> fetch()[0];

			$sql = "SELECT table_name 
			FROM api_available 
			WHERE router_name ='".$router_name."'";
			
			$querytablename = $connexion->query($sql);
			$table_name = $querytablename -> fetch()[0];

			$sql = "DELETE FROM ".$table_name." WHERE api_id=".$api_id;

			$query =  $connexion->exec($sql);

			$query2 = $connexion->prepare("DELETE FROM api
												WHERE api_id=:api_id");
			$query2->bindParam(':api_id', $api_id);
			$query2->execute();
			return $query2;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}
