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
		$data = $query->fetchAll();

		$query->closeCursor();
		return $data;
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