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
				<button data-popup="stoppedSubscription" class="button_default button_primary">Mon abonnement</button>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel panne_body settings_menu">
			<div class="row row-verti-center row-hori-around nowrap">
				<div class="link_block active">
					<a href="#" data-link-profil="inf" title="">Compte</a>
				</div>
				<?php if (!isset($_SESSION['additional'])) { ?>
				<div class="link_block">
					<a href="#" data-link-profil="sub" title="">Abonnement</a>
				</div>
				<div class="link_block">
					<a href="#" data-link-profil="fac" title="">Factures</a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
<!-- 	<div class="block full_block" data-task="inf">
		<div class="pannel pannel_body pannel_title">
			<h2>Informations de compte</h2>
		</div>
		<div class="pannel pannel_body">
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Société</span>
						<p>Indiquez la société dans laquelle vous travaillez</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="societe" class="button_default button_primary">Modifier</button>
						<p><span data-count="societe">1</span> société sauvegardée</p>
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
									<a href="#" data-delete='societe' title="">Supprimer</a>
								</p>
							</li>
							<li class="row row-hori-between nowrap">
								<p>Uber</p>
								<p>	
									<a href="#" data-delete='societe' title="">Supprimer</a>
								</p>
							</li>
							<li class="row row-hori-between nowrap">
								<p><strong><a href="#" data-add="societe" title="">Ajouter une société</a></strong></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between">
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
								<p><span id="lastName">de la Fouchardière</span> <span id="firstName">Victor</span></p>
								<p>	
									<a href="#" data-modif='prenom' title="">Modifier</a>
								</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Numéro de téléphone</span>
						<p>Ajoutez un numéro de téléphone au cas où vous auriez des problèmes d’identification</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="phone" class="button_default button_primary">Modifier</button>
						<p><span data-count="phone">1</span> numéro de téléphone enregistré</p>
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
									<a href="#" data-delete='phone' title="">Supprimer</a>
								</p>
							</li>
							<li class="row row-hori-between nowrap">
								<p><strong><a href="#" data-add="phone" title="">Ajouter numéro de téléphone</a></strong></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div> -->
	<div class="block full_block" data-task="inf">
		<div class="pannel pannel_body pannel_title">
			<h2>Informations de connexion</h2>
		</div>
		<div class="pannel pannel_body">
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Adresse e-mail</span>
						<?php if (!isset($_SESSION['additional'])) { ?>
						<p>Ajoutez ou supprimez des adresses e-mail sur votre compte</p>
						<?php } else { ?>
						<p>En tant qu'utilisateur lié, vous ne pouvez changer d'adresse email</p>
						<?php } ?>
					</div>
					<?php if (!isset($_SESSION['additional'])) { ?>
					<div class="col nowrap col-verti-around">
						<button data-info="email" class="button_default button_primary">Modifier</button>
						<p>2 adresses email enregistrées</p>
					</div>
					<?php } else { ?>
					<div class="col nowrap col-verti-around">
						<button disabled="disabled" class="button_default button_primary disabled">Modifier</button>
						<p><?= $_SESSION['additional']['user_additional_email']; ?></p>
					</div>
					<?php } ?>
				</div>
				<?php if (!isset($_SESSION['additional'])) { ?>
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
				<?php } ?>
			</div>
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between">
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
								<p>***********</p>
								<p>	
									<a href="#" title="" data-modif="password">Modifier</a>
								</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php if (!isset($_SESSION['additional'])) { ?>
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Utilisateurs</span>
						<p>Ajoutez des d'utilisateurs à votre compte selon votre abonnement.</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="user" class="button_default button_primary">Modifier</button>
						<p><span data-count="user"><?= count($users_additional); ?></span><?php if (isset($_SESSION['subscriber'])) { ?><?php if ($plan == 1): ?>/1<?php elseif($plan == 2): ?>/3<?php endif; } ?> utilisateurs enregistré(s)</p>
					</div>
				</div>
				<div id="user" class="info_accordeon">
					<div class="col nowrap">
						<div class="row nowrap sm_field">
							<p><strong>Voici les comptes utilisateurs que vous avez ajoutés :</strong></p>
						</div>
						<ul class="col nowrap sm_field" id="user_list">
							<?php foreach ($users_additional as $key => $user): ?>
								<li>
									<form class="row row-hori-between nowrap form-account" id="<?= $user['user_additional_id'];?>" action="">
										<p><?= $user['user_additional_email'];?></p>
										<p>	
											<input type="submit" title="" data-delete="user" value="Supprimer"/>
										</p>
									</form>
								</li>
							<?php endforeach ?>
							<li class="row row-hori-between nowrap">
								<p><strong><a href="#" data-add="user" title="">Ajouter un utilisateur</a></strong></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>		
	</div>
	<?php if (!isset($_SESSION['additional'])) { ?>
	<div class="block full_block" data-task="sub" style="display: none;">
		<div class="pannel pannel_body pannel_title">
			<h2>Votre abonnement actuel : </h2>
			<p class="legend"><button data-popup="stoppedSubscription" class="button_legend">Les détails</button></p>
		</div>
		<div class="pannel pannel_body pannel_legend">
			<p>Nos tarifs sont clairs et fixes. Vous aurez la possibilité de mettre votre compte en pause en fonction de votre activité et de le relancer quand vous le souhaiterez, sans perte de données.</p>
		</div>
		<div class="pannel pannel_body">
			<div class="row_cards row row-hori-around nowrap">
				<div class="card_block col nowrap">
					<header class="card_heading col col-hori-center col-verti-center nowrap">
						<span class="card_price">48&euro;<sub>/Mo</sub></span>
						<span class="card_name">Abonnement tip</span>
					</header>
					<div class="card_body">
						<ul class="col nowrap">
							<li><span>Utilisateur(s) :</span>1</li>
							<li><span>Modèles publics : </span><i class="material-icons ok">done</i></li>
							<li><span>Templates dédiés : </span><i class="material-icons nok">clear</i></li>
							<li><span>Implémentation de templates : </span><i class="material-icons nok">clear</i></li>
							<li><span>API :</span><i class="material-icons nok">clear</i></li>
							<li><span>Conseils : </span><i class="material-icons nok">clear</i></li>
						</ul>
					</div>
					<?php
					if ($subcription) {
						if ($plan == 1) { ?>
					<span class="subactual">Abonnement validé</span>
						<?php } else { ?>
					<footer class="card_footer">
						<form action="?module=user&action=upgrade" data-send-upgrade="1" method="POST">
							<button data-btn-upgrade="1" class="button_default">Upgrade</button>
						</form>
					</footer>
						<?php } 
					}
					else { ?>
					<footer class="card_footer">
						<form action="?module=user&action=subscribe" data-send-subscription="1" method="POST">
							<button data-btn-subscribe="1" class="button_default">S'abonner</button>
						</form>
					</footer>
					<?php } ?>
				</div>
				<div class="card_block col nowrap">
					<header class="card_heading col col-hori-center col-verti-center nowrap">
						<span class="card_price">72&euro;<sub>/Mo</sub></span>
						<span class="card_name">Abonnement top</span>
					</header>
					<div class="card_body">
						<ul class="col nowrap">
							<li><span>Utilisateur(s) :</span> 3</li>
							<li><span>Modèles publics : </span><i class="material-icons ok">done</i></li>
							<li><span>Templates dédiés : </span>3</li>
							<li><span>Implémentation de templates : </span><i class="material-icons nok">clear</i></li>
							<li><span>API :</span>1</li>
							<li><span>Conseils : </span><i class="material-icons nok">clear</i></li>
						</ul>
					</div>
					<?php
					if ($subcription) {
						if ($plan == 2) { ?>
					<span class="subactual">Abonnement validé</span>
						<?php } else { ?>
					<footer class="card_footer">
						<form action="?module=user&action=upgrade" data-send-upgrade="2" method="POST">
							<button data-btn-upgrade="2" class="button_default">Upgrade</button>
						</form>
					</footer>
						<?php } 
					}
					else { ?>
					<footer class="card_footer">
						<form action="?module=user&action=subscribe" data-send-subscription="2" method="POST">
							<button data-btn-subscribe="2" class="button_default">S'abonner</button>
						</form>
					</footer>
					<?php } ?>
				</div>
				<div class="card_block col nowrap">
					<header class="card_heading col col-hori-center col-verti-center nowrap">
						<span class="card_price">108&euro;<sub>/Mo</sub></span>
						<span class="card_name">Abonnement tip top</span>
					</header>
					<div class="card_body">
						<ul class="col nowrap">
							<li><span>Utilisateur(s) :</span> illimité</li>
							<li><span>Modèles publics : </span><i class="material-icons ok">done</i></li>
							<li><span>Templates dédiés : </span>5</li>
							<li><span>Implémentation de templates : </span><i class="material-icons ok">done</i></li>
							<li><span>API :</span>10+</li>
							<li><span>Conseils : </span><i class="material-icons ok">done</i></li>
						</ul>
					</div>
					<?php 
					if ($subcription) {
						if ($plan == 3) { ?>
					<span class="subactual">Abonnement validé</span>
						<?php } else { ?>
					<footer class="card_footer">
						<form action="?module=user&action=upgrade" data-send-upgrade="3" method="POST">
							<button data-btn-upgrade="3" class="button_default">Upgrade</button>
						</form>
					</footer>
						<?php } 
					}
					else { ?>
					<footer class="card_footer">
						<form action="?module=user&action=subscribe" data-send-subscription="3" method="POST">
							<button data-btn-subscribe="3" class="button_default">S'abonner</button>
						</form>
					</footer>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block" data-task="fac" style="display: none;">
		<div class="pannel pannel_body pannel_title">
			<h2>Vos factures (3)</h2>
			<p class="legend"><button class="button_legend">Mes informations de paiement</button></p>
		</div>
		<div class="pannel pannel_body container_to_table">
			<table class="table_fac">
				<thead>
					<tr>
						<th>ID de facture</th>
						<th>Abonnement</th>
						<th>Montant (ttc)</th>
						<th>Date</th>
						<th>PDF</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>5893</td>
						<td>Abonnemen tip</td>
						<td>108€</td>
						<td>27/04/2017</td>
						<td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
					</tr>
					<tr>
						<td>4781</td>
						<td>Abonnemen top</td>
						<td>78€</td>
						<td>29/01/2017</td>
						<td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="popup_mc" id="stoppedSubscription">
		<div class="popup_background"></div>
		<div class="popup_container"></div>
	</div>
	<?php } ?>
</div>
		
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>