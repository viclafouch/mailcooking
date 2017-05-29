<?php 
	// Secu
	protec();
	just_admin();
	
	$users = selecttable('users',
				array('orderby' => 'timestamp',
					'order' => 'DESC',
			));

	$nb_users = counttable("users");

	metadatas('Les utilisateurs', 'Description', 'none');

	include_once('app/view/admin/users.php');