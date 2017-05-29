<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Mot de passe oublié</title>
	</head>
	<body>
		<div class="col-md-6">
			<h1>PASSWORD RECOVER</h1>
			<form action="?module=home&action=recovery_password&id=<?php echo $_GET['id'];?>" method="post">
				<input type="password" name="password1" placeholder="mdplolola">
				</br>
				<input type="password" name="password2" placeholder="mdplolola">
				</br>
				<input type="submit" value="RESET PASSWORD">
			</form>
		</div>
	</body>
</html>

