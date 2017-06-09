<?php

	if (!empty($_POST)) {
		if (isset($_FILES)) {
			$data['file'] = $_FILES;
		    $data['text'] = $_POST;
		 
		    echo json_encode($_POST["id"]);
		}
	}
	else {
	    $data['file'] = $_FILES;
	    $data['text'] = $_POST;
	 
	    echo json_encode($data);
	}
?>