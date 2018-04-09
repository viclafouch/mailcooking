<?php 

// Liste des catégories 
function selecttable($table, $options=array())			
{
	global $connexion;

	try 
	{
		// On voit la requête
		$sql = 'SELECT * FROM ' . $table;

		if ((isset($options['wherecolumn'])) && (isset($options['wherevalue']))) {
			$sql .= ' WHERE ' . $options["wherecolumn"] . '="' . $options["wherevalue"] . '"';
		}

		if (isset($options['orderby'])) {
			$sql .= ' ORDER BY ' . $options["orderby"];
			if (isset($options["order"])) {
				$sql .= ' ' . $options["order"];
			}
		}
		if (isset($options['limit'])) {
			$sql .= ' LIMIT ';
			if (isset($options["offset"])) {
			$sql .= $options["offset"] . " , ";
			}
			$sql .= $options["limit"];

		}
		// var_dump($sql);
		$query = $connexion->query($sql);
		// On récupère tous les résultats
		$data =$query->fetchAll(PDO::FETCH_ASSOC);
		
		$query->closeCursor();

		if($table === 'api'){
			foreach ($data as $key => $api_conf){
				$router_name =  $data[$key]["router_name"];

				$sql = "SELECT 
				table_name, unsub, mirror 
				FROM api_available 
				WHERE router_name =:router_name";
				
				$query = $connexion->prepare($sql);
				$query->bindParam(":router_name",    $router_name, PDO::PARAM_STR);
		
				$query -> execute();
				
				$values = $query->fetch(PDO::FETCH_ASSOC);
				$query->closeCursor();

				$data[$key]['unsub'] =  $values['unsub'];
				$data[$key]['mirror'] = $values['mirror'];
				$table_name = $values['table_name'];

				$id_api = $data[$key]['api_id'];
				
				$sqlb = "SELECT * 
						FROM $table_name
						WHERE api_id=:id_api";
				
				$query2 = $connexion -> prepare($sqlb);
				
				$query2-> bindParam(":id_api", $id_api, PDO::PARAM_INT);

				$query2 -> execute();
				$values = $query2->fetch(PDO::FETCH_ASSOC);

				$data[$key]['api_info'] = $values;
				$query2->closeCursor();
			};
		};

		return $data;

	}	
	catch (Exception $e) 
	{
		die("Erreur SQL : " . $e->getMessage());
	}
}
function getApiList(){
	global $connexion;

	try 
	{
		$sql = "SELECT * 
				FROM api_available";
		$query = $connexion->query($sql);
		// On récupère tous les résultats
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		
		$query->closeCursor();
		$apiConfig = array();
		
		foreach ($data as $key => $api_conf){
			$table_name =  $data[$key]["table_name"];
			
			$sql = "SHOW COLUMNS 
				FROM ".$table_name;
			
				$query = $connexion->query($sql);
				$apiInfos = $query -> fetchAll(PDO::FETCH_ASSOC);
				$query->closeCursor();
				$apiFields = array();
				foreach ($apiInfos as $keyb => $api_confb){
					if($api_confb["Field"] !== 'api_id'){
						array_push($apiFields,	$api_confb["Field"]);
					};
				};

				$apiConfig[$data[$key]['router_name']] = $apiFields;
		}
		
		// return $apiConfig;
		return json_encode($apiConfig);
	}
	catch (Exception $e) 
	{
		die("Erreur SQL : " . $e->getMessage());
	}
}
function counttable($table, $options=array()) {
	global $connexion;

	try {

		$sql = 'SELECT count(*) AS nb FROM ' . $table;
		// On voit la requête
		if ((isset($options['wherecolumn'])) && (isset($options['wherevalue']))) {
			$sql .= ' WHERE ' . $options["wherecolumn"] . '="' . $options["wherevalue"] . '"';
		}
		$query = $connexion->prepare($sql);				
		// On exécute la requête
		$query->execute();

		// On récupère tous les résultats
		$result = $query->fetch();

		$query->closeCursor();
		return $result['nb'];
	}
	
	catch (Exception $e) 
	{
		die("Erreur SQL : " . $e->getMessage());
	}
}