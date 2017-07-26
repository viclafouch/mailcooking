<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Confirmer votre compte</title>
	</head>
	<body>
		<div class="col-md-6">
			<h1>Confirmer le compte utilisateur</h1>
			<form action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method="post">
				<p><input type="text" name="firstname" placeholder="Jean"></p>
				<p><input type="text" name="lastname" placeholder="Dupont"></p>
				<p><input type="password" name="password1" placeholder="**********"></p>
				<p><input type="password" name="password2" placeholder="**********"></p>
				<br/>
				<input type="submit" value="RESET PASSWORD">
			</form>
		</div>
	</body>
</html>
