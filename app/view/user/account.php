<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>
<div class="user_update">
	<div class="nwrap">
		<h1>Mon profil</h1>
	</div>
	<div class="block_update">
		<form action="?module=user&action=modif" method="post" id="form__modif_user_account" class="form_update_user">
			<fieldset>
				<legend>Informations de compte</legend>
				<div class="field">
					<label for="first_name">Prénom</label>
					<input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user[0]["first_name"]); ?>" required/>
				</div>
				<div class="field">
					<label for="last_name">Nom</label>
					<input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($user[0]["last_name"]); ?>" required/>
				</div>
				<div class="field">
					<label for="societe">Société</label>
					<input type="text" name="societe" id="societe" value="<?php echo htmlspecialchars($user[0]["societe"]); ?>" required/>
				</div>
				<div class="field">
					<label for="nb_phone">Numéro de téléphone</label>
					<input type="text" name="nb_phone" id="nb_phone" value="<?php echo htmlspecialchars($user[0]["nb_phone"]); ?>" />
				</div>
				<div class="action__button">
					<input type="submit" value="Modifier mes informations">
					<div class="loader_post"></div>
				</div>
			</fieldset>
		</form>
		<hr>
		<form action="?module=user&action=modif" method="post" class="form_update_user">
			<fieldset>
				<legend>Informations de connexion</legend>
				<div class="field">
					<label for="user_email">Email</label>
					<input type="email" name="user_email" id="user_email" value="<?= $user[0]['user_email']; ?>" required readonly/>
				</div>
				<div class="field">
					<label for="user_password_actual">Mot de passe actuel</label>
					<input type="password" name="user_password" value="" id="user_password" required/>
				</div>
				<div class="field">
					<label for="user_password">Nouveau Mot de passe</label>
					<input type="password" name="user_password" value="" id="user_password" required/>
				</div>
				<div class="field">
					<label for="user_password_confirm">Répéter Mot de passe (bis)</label>
					<input type="password" name="user_password_confirm" id="user_password_confirm" value="" required/>
				</div>
				<div class="action__button">
					<input type="submit" value="Modifier le mot de passe">
				</div>
			</fieldset>
		</form>
	</div>
</div>
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>