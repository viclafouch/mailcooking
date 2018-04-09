<?php 
	function delete_users($user_additional_admin_id) {

		global $connexion;

		try {
			$query = $connexion->prepare('DELETE FROM users_additional
												WHERE user_additional_admin_id=:user_additional_admin_id');

			$query->bindParam(':user_additional_admin_id', $user_additional_admin_id, PDO::PARAM_INT);

			$query->execute();
			return $query;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}

	function delete_api($user_admin_id){
		global $connexion;
		try {
			$option2 = array( 
				'wherecolumn' 	=> 	'user_admin_id',
				'wherevalue'	=>	$user_admin_id,
			);
			$api = selecttable('api', $option2);
			foreach($api as $key => $values ){
				$router_name = $values['router_name'];
				$api_id = $values['api_id'];
				// Get table name
				$getTableName = $connexion->prepare('SELECT table_name FROM api_available WHERE router_name=\''.$router_name.'\'');
				$getTableName -> execute(array('.$router_name.' => $router_name));
				$table_name = $getTableName->fetch(PDO::FETCH_ASSOC)['table_name'];

				$query = $connexion->prepare('DELETE FROM '.$table_name.' WHERE api_id=\''.$api_id.'\'');
				$query-> execute(array('.$table_name.' => $table_name, '.$api_id.' => $api_id));
			};
			$query = $connexion->prepare('DELETE FROM api
												WHERE user_admin_id=\''.$user_admin_id.'\'');

			$query-> execute(array('.$user_admin_id.' => $user_admin_id));
			return $query;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}
