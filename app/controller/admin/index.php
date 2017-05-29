<?php 
	// Secu
	protec();
	just_admin();
	

	metadatas('Backoffice', 'Description', 'none');
	
	// Appel de la view
	include_once("app/view/admin/index.php");