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
					<a href="#" data-link-profil="fac" title="">Factures</a>
				</div>
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
						<p>Ajoutez ou supprimez des adresses e-mail sur votre compte</p>
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
								<p>*******</p>
								<p>	
									<a href="#" title="">Modifier</a>
								</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between">
					<div class="col nowrap col-verti-around">
						<span>Utilisateurs</span>
						<p>Ajoutez des d'utilisateurs à votre compte selon votre abonnement.</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="user" class="button_default button_primary">Modifier</button>
						<p><span data-count="user"><?= count($users_additional); ?></span> utilisateurs enregistré(s)</p>
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
											<a href="#" title="" data-delete="user">Supprimer</a>
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
		</div>		
	</div>
	<div class="block full_block" data-task="sub" style="display: none;">
		<div class="pannel pannel_body pannel_title">
			<h2>Votre abonnement actuel : </h2>
			<p class="legend"><button data-popup="profilRenewal" class="button_legend">Date de renouvellement</button></p>
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
						<button id="btn__upgradeToTip" class="button_default">Upgrade</button>
						<form action="?module=user&action=upgrade" id="paiement-form-1" method="POST">
							<script>
							var handleUpgradeTip = StripeCheckout.configure({
							  	key: 'pk_test_jdtjz4b05ADqlx5k093fsmgK',
							  	image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
							  	locale: 'auto',
							  	token: function(token) {
								    var $inputToken = $('<input type=hidden name=stripeToken />').val(token.id);
								    var $inputPlan = $('<input type=hidden name=plan />').val('1');
  									$('#paiement-form-1').append($inputToken).append($inputPlan).submit();
							  	}
							});

							document.getElementById('btn__upgradeToTip').addEventListener('click', function(e) {
							  	handleUpgradeTip.open({
								    name: 'Mailcooking',
								    description: 'Abonnement tip',
								    zipCode: true,
								    amount: 4800,
								    currency: 'EUR'
								});
							  e.preventDefault();
							});

							// Close Checkout on page navigation:
							window.addEventListener('popstate', function() {
							  	handleUpgradeTip.close();
							});
							</script>
						</form>
					</footer>
						<?php } 
					}
					else { ?>
					<footer class="card_footer">
						<form action="?module=user&action=subscribe&tip" id="paiement-form-1" method="POST">
							<button id="formtip" class="button_default">S'abonner</button>
						
							<script>
							var handlerTip = StripeCheckout.configure({
							  	key: 'pk_test_jdtjz4b05ADqlx5k093fsmgK',
							  	image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
							  	locale: 'auto',
							  	token: function(token) {
								    var $input = $('<input type=hidden name=stripeToken />').val(token.id);
								    var $theEmail = $('<input type=hidden name=stripeEmail />').val(token.email);
  									$('#paiement-form-1').append($input).append($theEmail).submit();
							  	}
							});

							document.getElementById('formtip').addEventListener('click', function(e) {
							  	handlerTip.open({
								    name: 'Mailcooking',
								    description: 'Abonnement tip',
								    zipCode: true,
								    amount: 4800,
								    currency: 'EUR'
								});
							  e.preventDefault();
							});

							// Close Checkout on page navigation:
							window.addEventListener('popstate', function() {
							  	handlerTip.close();
							});
							</script>
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
						<button id="btn__upgradeToTop" class="button_default">Upgrade</button>
						<form action="?module=user&action=upgrade" id="paiement-form-2" method="POST">
							<script>
							var handleUpgradeTop = StripeCheckout.configure({
							  	key: 'pk_test_jdtjz4b05ADqlx5k093fsmgK',
							  	image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
							  	locale: 'auto',
							  	token: function(token) {
								    var $inputToken = $('<input type=hidden name=stripeToken />').val(token.id);
								    var $inputPlan = $('<input type=hidden name=plan />').val('2');
  									$('#paiement-form-2').append($inputToken).append($inputPlan).submit();
							  	}
							});

							document.getElementById('btn__upgradeToTop').addEventListener('click', function(e) {
							  	handleUpgradeTop.open({
								    name: 'Mailcooking',
								    description: 'Abonnement top',
								    zipCode: true,
								    amount: 7200,
								    currency: 'EUR'
								});
							  e.preventDefault();
							});

							// Close Checkout on page navigation:
							window.addEventListener('popstate', function() {
							  	handleUpgradeTop.close();
							});
							</script>
						</form>
					</footer>
						<?php } 
					}
					else { ?>
					<footer class="card_footer">
						<button id="btn__subscribeToTop" class="button_default">S'abonner</button>
						<form action="?module=user&action=subscribe&top" id="paiement-form-2" method="POST">
							<script>
							var handlerTop = StripeCheckout.configure({
							  	key: 'pk_test_jdtjz4b05ADqlx5k093fsmgK',
							  	image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
							  	locale: 'auto',
							  	token: function(token) {
								    var $input = $('<input type=hidden name=stripeToken />').val(token.id);
  									var $theEmail = $('<input type=hidden name=stripeEmail />').val(token.email);
  									$('#paiement-form-1').append($input).append($theEmail).submit();
							  	}
							});

							document.getElementById('btn__subscribeToTop').addEventListener('click', function(e) {
							  	handlerTop.open({
								    name: 'Mailcooking',
								    description: 'Abonnement top',
								    zipCode: true,
								    amount: 7200,
								    currency: 'EUR'
								});
							  e.preventDefault();
							});

							// Close Checkout on page navigation:
							window.addEventListener('popstate', function() {
							  	handlerTop.close();
							});
							</script>
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
						<button id="btn__upgradeToTipTop" class="button_default">Upgrade</button>
						<form action="?module=user&action=upgrade" id="paiement-form-3" method="POST">
							<script>
							var handleUpgradeTipTop = StripeCheckout.configure({
							  	key: 'pk_test_jdtjz4b05ADqlx5k093fsmgK',
							  	image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
							  	locale: 'auto',
							  	token: function(token) {
								    var $inputToken = $('<input type=hidden name=stripeToken />').val(token.id);
								    var $inputPlan = $('<input type=hidden name=plan />').val('3');
  									$('#paiement-form-3').append($inputToken).append($inputPlan).submit();
							  	}
							});

							document.getElementById('btn__upgradeToTipTop').addEventListener('click', function(e) {
							  	handleUpgradeTipTop.open({
								    name: 'Mailcooking',
								    description: 'Abonnement tip top',
								    zipCode: true,
								    amount: 10800,
								    currency: 'EUR'
								});
							  e.preventDefault();
							});

							// Close Checkout on page navigation:
							window.addEventListener('popstate', function() {
							  	handleUpgradeTipTop.close();
							});
							</script>
						</form>
					</footer>
						<?php } 
					}
					else { ?>
					<footer class="card_footer">
						<form action="?module=user&action=subscribe&tiptop" id="paiement-form-3" method="POST">
							<button id="formtiptop" class="button_default">S'abonner</button>
						
							<script>
							var handlerTipTop = StripeCheckout.configure({
							  	key: 'pk_test_jdtjz4b05ADqlx5k093fsmgK',
							  	image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
							  	locale: 'auto',
							  	token: function(token) {
								    var $input = $('<input type=hidden name=stripeToken />').val(token.id);
  									var $theEmail = $('<input type=hidden name=stripeEmail />').val(token.email);
  									$('#paiement-form-3').append($input).append($theEmail).submit();
							  	}
							});

							document.getElementById('formtiptop').addEventListener('click', function(e) {
							  	handlerTipTop.open({
								    name: 'Mailcooking',
								    description: 'Abonnement tip top',
								    zipCode: true,
								    amount: 10800,
								    currency: 'EUR'
								});
							  e.preventDefault();
							});

							// Close Checkout on page navigation:
							window.addEventListener('popstate', function() {
							  	handlerTipTop.close();
							});
							</script>
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
	<div class="popup_mc" id="profilRenewal">
		<div class="popup_background"></div>
		<div class="popup_container">
			<header>
				<h1>REVENOUVELLEMENT</h1>
			</header>
			<form method="post" action="">
				<div class="content_block popup-blocks">
					<div>
						<div class="field">
							<div class="oneside aside">
								<label>Date du prochain prévèlement :</label>
							</div>
							<div class="overside aside">
								<p>15/08/2017</p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label>Renouvellement automatique :*</label>
							</div>
							<div class="overside aside">
								<p>
									<input type="checkbox" id="check1" class="checkbonito"/>
   									<label for="check1"></label>
								</p>
							</div>
						</div>
					</div>
				</div>
				<footer>
					<button data-close-popup class="button_default button_secondary">Sauvegarder</button>
				</footer>
			</form>
		</div>
	</div>
</div>
		
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>