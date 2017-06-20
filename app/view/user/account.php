<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_profil">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-verti-center row-hori-between">
				<div>
					<h1>Mon profil</h1>
				</div>
				<button type="submit" class="button_default button_primary">Mon abonnement</button>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel panne_body settings_menu">
			<div class="row row-verti-center row-hori-around nowrap">
				<div class="link_block active">
					<a href="#" data-link-profil="inf" title="">Compte</a>
				</div>
				<div class="link_block">
					<a href="#" data-link-profil="sub" title="">Abonnement</a>
				</div>
				<div class="link_block">
					<a href="#" data-link-profil="com" title="">Communication</a>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body">
			<h2>Informations de compte</h2>
		</div>
		<div class="pannel pannel_body">
			<form action="?module=user&action=modif" method="post" id="form__modif_user_account">
				<fieldset>
					<div class="col nowrap">
						<div class="field row nowrap row-hori-between">
							<div class="col nowrap col-verti-around">
								<span>Adresse e-mail</span>
								<p>Ajouter ou supprimez des adresses e-mail sur votre compte</p>
							</div>
							<div class="col nowrap col-verti-around">
								<button data-info="email" class="button_default button_primary">Modifier</button>
								<p>1 adresse email esssssnregistrée</p>
							</div>
						</div>
						<div id="email" class="info_accordeon">
							<div class="col nowrap">
								<div class="row nowrap sm_field">
									<p><strong>Voici les adresses e-mail que vous avez ajoutées :</strong></p>
								</div>
								<ul class="col nowrap sm_field" id="email_list">
									<li class="row row-hori-between nowrap">
										<p>victor.dlf@outlook.fr</p>
										<span>Adresse principale</span>
									</li>
									<li class="row row-hori-between nowrap">
										<p>victor.dlf@outlook.fr</p>
										<p>	
											<a href="#" title="">Choisir comme adresse principale</a> - <a href="#" title="">Supprimer</a>
										</p>
									</li>
									<li class="row row-hori-between nowrap">
										<p><strong><a href="#" title="">Ajouter une adresse email</a></strong></p>
									</li>
								</ul>
							</div>
						</div>
						
					</div>
					<div id="prenom" class="field row nowrap row-hori-between">
						<div class="col nowrap col-verti-around">
							<span>Prénom</span>
							<p>Choisissez votre nom / prénom en cas de contact de Mailcooking</p>
						</div>
						<div class="col nowrap col-verti-around">
							<button data-info="prenom" class="button_default button_primary">Modifier</button>
							<p>Prénom sauvegardé</p>
						</div>
					</div>
					<!-- <div class="field row nowrap row-hori-between">
						<label for="first_name">Prénom *</label>
						<input type="text" name="first_name" spellcheck="false" id="first_name" value="<?php echo htmlspecialchars($user[0]["first_name"]); ?>" required/>
					</div> -->
					<!-- <div class="field row nowrap row-hori-between">
						<label for="last_name">Nom *</label>
						<input type="text" name="last_name" spellcheck="false" id="last_name" value="<?php echo htmlspecialchars($user[0]["last_name"]); ?>" required/>
					</div>
					<div class="field row nowrap row-hori-between">
						<label for="societe">Société *</label>
						<input type="text" disabled="disabled" readonly name="societe" id="societe" value="<?php echo htmlspecialchars($user[0]["societe"]); ?>" required/>
					</div>
					<div class="field row nowrap row-hori-between">
						<label for="nb_phone">Numéro de téléphone *</label>
						<input type="text" name="nb_phone" id="nb_phone" required value="<?php echo htmlspecialchars($user[0]["nb_phone"]); ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
					</div>
					<div class="row row-verti-center nowrap">
						<button type="submit" class="button_default button_primary">Enregistrer les modifications</button>
						<div class="loader_post"></div>
					</div> -->
				</fieldset>
			</form>
		</div>
<!-- 		<div class="pannel pannel_body">
			<form action="?module=user&action=modif" method="post" class="form_update_user">
				<fieldset>
					<legend>Informations de connexion</legend>
					<div class="field row nowrap row-hori-between">
						<label for="user_email">Email</label>
						<input type="email" name="user_email" id="user_email" value="<?= $user[0]['user_email']; ?>" required readonly/>
					</div>
					<div class="field row nowrap row-hori-between">
						<label for="user_password_actual">Mot de passe actuel</label>
						<input type="password" name="user_password" value="" id="user_password" required/>
					</div>
					<div class="field row nowrap row-hori-between">
						<label for="user_password">Nouveau Mot de passe</label>
						<input type="password" name="user_password" value="" id="user_password" required/>
					</div>
					<div class="field row nowrap row-hori-between">
						<label for="user_password_confirm">Répéter Mot de passe (bis)</label>
						<input type="password" name="user_password_confirm" id="user_password_confirm" value="" required/>
					</div>
					<div class="row row-verti-center nowrap">
						<button type="submit" class="button_default button_primary">Enregistrer les modifications</button>
					</div>
				</fieldset>
			</form>
		</div> -->
	</div>
</div>
		
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>