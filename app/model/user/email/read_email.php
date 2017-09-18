<?php 

	function read_email($id) {
		global $connexion;

		try {
			$query = $connexion->prepare('SELECT * 
											FROM template_mail
												WHERE id_template=:id');

			$query->bindParam(':id', $id, PDO::PARAM_INT);

			$query->execute();
			$email = $query->fetchAll();
			$query->closeCursor();

			return $email;
		}
		
		catch (Exception $e) {
			die("Erreur SQL : " . $e->getMessage());
		}
	}