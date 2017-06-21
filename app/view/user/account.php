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
			<div class="col nowrap">
				<div class="field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Société</span>
						<p>Indiquez la société dans laquelle vous travaillez</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="societe" class="button_default button_primary">Modifier</button>
						<p>1 société sauvegardée</p>
					</div>
				</div>
				<div id="societe" class="info_accordeon">
					<div class="col nowrap">
						<div class="row nowrap sm_field">
							<p><strong>Voici les sociétés que vous avez ajoutées :</strong></p>
						</div>
						<ul class="col nowrap sm_field" id="societe_list">
							<li class="row row-hori-between nowrap">
								<p>Google</p>
								<p>	
									<a href="#" title="">Supprimer</a>
								</p>
							</li>
							<li class="row row-hori-between nowrap">
								<p>Uber</p>
								<p>	
									<a href="#" title="">Supprimer</a>
								</p>
							</li>
							<li class="row row-hori-between nowrap">
								<p><strong><a href="#" title="">Ajouter une société</a></strong></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col nowrap">
				<div class="field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Nom</span>
						<p>Indiquez votre nom / prénom en cas de contact de Mailcooking</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="prenom" class="button_default button_primary">Modifier</button>
						<p>Prénom sauvegardé</p>
					</div>
				</div>
				<div id="prenom" class="info_accordeon">
					<div class="col nowrap">
						<div class="row nowrap sm_field">
							<p><strong>Nom / Prénom :</strong></p>
						</div>
						<ul class="col nowrap sm_field" id="name_list">
							<li class="row row-hori-between nowrap">
								<p>de la Fouchardière Victor</p>
								<p>	
									<a href="#" title="">Modifier</a>
								</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col nowrap">
				<div class="field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Numéro de téléphone</span>
						<p>Ajoutez un numéro de téléphone au cas où vous auriez des problèmes d’identification</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="phone" class="button_default button_primary">Modifier</button>
						<p>1 numéro de téléphone enregistré</p>
					</div>
				</div>
				<div id="phone" class="info_accordeon">
					<div class="col nowrap">
						<div class="row nowrap sm_field">
							<p><strong>Les numéros de téléphone que vous avez ajoutés :</strong></p>
						</div>
						<ul class="col nowrap sm_field" id="phone_list">
							<li class="row row-hori-between nowrap">
								<p>FR +33 626922635</p>
								<p>	
									<a href="#" title="">Supprimer</a>
								</p>
							</li>
							<li class="row row-hori-between nowrap">
								<p><strong><a href="#" title="">Ajouter numéro de téléphone</a></strong></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body">
			<h2>Informations de connexion</h2>
		</div>
		<div class="pannel pannel_body">
			<div class="col nowrap">
				<div class="field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Adresse e-mail</span>
						<p>Ajouter ou supprimez des adresses e-mail sur votre compte</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="email" class="button_default button_primary">Modifier</button>
						<p>2 adresses email enregistrées</p>
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
								<p>antoine.dlf@outlook.fr</p>
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
			<div class="col nowrap">
				<div class="field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Mot de passe</span>
						<p>Choisissez un mot de passe unique pour protéger votre compte</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="password" class="button_default button_primary">Modifier</button>
						<p>Modifié le 24/04/2016</p>
					</div>
				</div>
				<div id="password" class="info_accordeon">
					<div class="col nowrap">
						<div class="row nowrap sm_field">
							<p><strong>Votre mot de passe actuel :</strong></p>
						</div>
						<ul class="col nowrap sm_field" id="password_list">
							<li class="row row-hori-between nowrap">
								<p>*******</p>
								<p>	
									<a href="#" title="">Modifier</a>
								</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
		
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>