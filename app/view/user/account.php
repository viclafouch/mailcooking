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
	<div class="block full_block" data-task="inf">
		<div class="pannel pannel_body pannel_title">
			<h2>Informations de connexion</h2>
		</div>
		<div class="pannel pannel_body">
			<!-- <div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between" data-field="email">
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
								<p><a href="#" title="">Ajouter une adresse email</a></p>
							</li>
						</ul>
					</div>
				</div>
				<?php } ?>
			</div> -->
			<!-- ACCORDEON MDP -->
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between" data-field="password">
					<div class="col nowrap col-verti-around">
						<span>Mot de passe</span>
						<p>Choisissez un mot de passe unique pour protéger votre compte</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="password" class="button_default button_primary">Modifier</button>
						<p>Ne jamais divulger votre mot de passe</p>
					</div>
				</div>
				<div id="password" class="info_accordeon">
					<div class="col nowrap">
						<div class="row nowrap sm_field">
							<p>Votre mot de passe actuel :</p>
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
			

			<!-- ACCORDEON ADRESSES -->

			<?php if (!isset($_SESSION['additional'])) { ?>
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between" data-field="adresse_factu">
					<div class="col nowrap col-verti-around">
						<span>Adresse de facturation</span>
						<p>Renseignez l'adresse qui apparaitra sur vos factures</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="adresse_factu" class="button_default button_primary">Modifier</button>
						<p><?php
							if($_SESSION['user']['adress']){
								echo 'adresse renseignée';
							}
							else{
								echo 'adresse non renseignée';
							}
						 ?></p>
					</div>
				</div>
				<div id="adresse_factu" class="info_accordeon">
						<div class="col nowrap">
							<div class="row nowrap sm_field">
								<p>Votre adresse :</p>
							</div>
							<ul class="col nowrap sm_field" id="adresse_factu">
								<li class="row row-hori-between nowrap">
									<p><?php if($_SESSION['user']['adress']){
											echo $_SESSION['user']['adress'];
										}
										else{
											echo 'adresse non renseignée';
										} ?>
									</p>
									<p>	
										<a href="#" title="" data-modif="adresse_factu">Modifier</a>
									</p>
								</li>
							</ul>
						</div>
				</div>
			</div>		
			<?php } ?>

			<?php if (!isset($_SESSION['additional'])) { ?>
			<!-- ACCORDEON CARTES -->
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between" data-field="payment">
					<div class="col nowrap col-verti-around">
						<span>Moyens de paiement</span>
						<p>Managez vos moyens de paiement</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="payment" class="button_default button_primary">Modifier</button>
						<p><?php
							if(count($cards) > 1){
								echo count($cards) .' cartes enregistrées'; 
							}
							else{
								echo count($cards) .' carte enregistrée'; 
							}
						 ?></p>
					</div>
				</div>
				<div id="payment" class="info_accordeon">
					<?php foreach ($cards as $key => $card): ?>
						<div class="col nowrap">
							<div class="row nowrap sm_field">
								<p><?php echo $card -> brand; ?>:</p>
							</div>
							<ul class="col nowrap sm_field" id="paiement_list">
								<li class="row row-hori-between nowrap">
									<p>XXX XXX XXX <?php echo $card -> last4; ?></p>
									<p>	
									<form action="?module=user&action=updatecard" data-update-card="" method="POST">
										<input type="submit" title="" data-paymentdefaut="updatecard" value="Mettre à jour vos informations"/>
									</form>
									</p>
								</li>
							</ul>
						</div>
					<?php endforeach ?>
				</div>
			</div>
			<?php } ?>
			<!-- ACCORDEON UTILISATEURS -->
			<?php if (!isset($_SESSION['additional'])) { ?>
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between" data-field="user">
					<div class="col nowrap col-verti-around">
						<span>Utilisateurs</span>
						<p>Ajoutez des d'utilisateurs à votre compte selon votre abonnement.</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="user" class="button_default button_primary">Modifier</button>
						<p>
							<span data-count="user"><?= count($users_additional); ?></span>
							<?php if (isset($_SESSION['subscriber'])) { 
							?>/<?= $_SESSION['subscription']['users'];?>
							<?php } ?>utilisateurs enregistré(s)
						</p>
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
								<p><a href="#" data-add="user" title="">Ajouter un utilisateur</a></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>

			<!-- ACCORDEON API -->
			<?php if (!isset($_SESSION['additional'])) { ?>
			<div class="col nowrap">
				<div class="bg_field row nowrap row-hori-between" data-field="api">
					<div class="col nowrap col-verti-around">
						<span>API</span>
						<p>Configurez vos API pour pousser vos messsages vers votre routeur</p>
					</div>
					<div class="col nowrap col-verti-around">
						<button data-info="api" class="button_default button_primary">Modifier</button>
						<p>
							<span data-count="api"><?= count($api); ?></span>
							<?php if ($_SESSION['subscription']['API']) { 
							?>/<?= $_SESSION['subscription']['API'];?>
							<?php } ?>API enregistré(s)
						</p>
					</div>
				</div>
				<div id="api" class="info_accordeon">
					<div class="col nowrap">
						<div class="row nowrap sm_field">
							<p><strong>Voici les comptes API que vous avez ajoutés :</strong></p>
						</div>
						<ul class="col nowrap sm_field" id="api_list">
							<?php foreach ($api as $key => $api_conf): ?>
								<li>
									<form class="row row-hori-between nowrap form-account" id="<?= $api_conf['api_id'];?>" action="">
										<p><?= $api_conf['router_name'];?></p>
										<p><?= substr($api_conf['api_info']['api_key'], 0, 20) .'...';?></p>
										<p>	
											<input type="submit" title="" data-delete="api" value="Supprimer"/>
										</p>
									</form>
								</li>
							<?php endforeach ?>
							<li class="row row-hori-between nowrap">
								<p><a href="#" data-add="api" title="">Ajouter un API</a></p>
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
		<!-- <div class="pannel pannel_body pannel_title">
			<h2>Votre abonnement actuel : </h2>
			<p class="legend"><button data-popup="stoppedSubscription" class="button_legend">Les détails</button></p>
		</div>
		<div class="pannel pannel_body pannel_legend">
			<p>Nos tarifs sont clairs et fixes. Vous aurez la possibilité de mettre votre compte en pause en fonction de votre activité et de le relancer quand vous le souhaiterez, sans perte de données.</p>
		</div> -->
		<div class="pannel pannel_body">
			<div class="row_cards row row-hori-around nowrap">
				<?php foreach ($MC_subscriptions as $key => $subscription): ?>
					<div class="card_block col nowrap">
					<header class="card_heading col col-hori-center col-verti-center nowrap">
						<span class="card_price"><?= $subscription['price'].$currency;?><sub>/Mo</sub></span>
						<span class="card_name"><?= $subscription['name']; ?></span>
					</header>
					<div class="card_body">
						<ul class="col nowrap">
							<li><span>Utilisateur(s) :</span><?= $subscription['users']; ?></li>

							<?php if ($subscription['publicModels']): ?>
							<li><span>Modèles publics : </span><i class="material-icons ok">done</i></li>
							<?php else: ?>
							<li><span>Modèles publics : </span><i class="material-icons nok">clear</i></li>
							<?php endif; ?>

							<?php if ($subscription['privateTemplate']): ?>
							<li><span>Templates dédiés : </span><?= $subscription['privateTemplate']; ?></li>
							<?php else: ?>
							<li><span>Templates dédiés : </span><i class="material-icons nok">clear</i></li>
							<?php endif; ?>

							<?php if ($subscription['implementCode']): ?>
							<li><span>Implémentation de templates : </span><i class="material-icons ok">done</i></li>
							<?php else: ?>
							<li><span>Implémentation de templates : </span><i class="material-icons nok">clear</i></li>
							<?php endif; ?>

							<?php if ($subscription['API']): ?>
							<li><span>API : </span><?= $subscription['API']; ?></li>
							<?php else: ?>
							<li><span>API : </span><i class="material-icons nok">clear</i></li>
							<?php endif; ?>

							<?php if ($subscription['advice']): ?>
							<li><span>Conseils : </span><i class="material-icons ok">done</i></li>
							<?php else: ?>
							<li><span>Conseils : </span><i class="material-icons nok">clear</i></li>
							<?php endif; ?>
						</ul>
					</div>
					<?php 
						if (isset($_SESSION['subscriber'])) {
							if ($plan == $subscription['id']) { ?>

							<span class="subactual">Abonnement validé</span>
							<footer class="card_footer">
									<button class="button_default" id="stopSubscriptionFromPricingTable" data-popup="stoppedSubscription">
										Stopper l'abonnement
									</button>
							</footer>
							<?php } 

							else { ?>
							
							<footer class="card_footer">
								<form action="?module=user&action=upgrade" data-send-upgrade="<?= $subscription['id']; ?>" method="POST">
									<button data-btn-upgrade="<?= $subscription['id']; ?>" class="button_default">
										<?php
											if ($plan > $subscription['id']){
												echo 'Downgrade';
											}
											else{
												echo 'Upgrade';
											}
										?>
									</button>
								</form>
							</footer>
							<?php 
							
						}
					}
						else { ?>
							<footer class="card_footer">
								<form action="?module=user&action=subscribe" data-send-subscription="<?= $subscription['id']; ?>" method="POST">
									<button data-btn-subscribe="<?= $subscription['id']; ?>" class="button_default">S'abonner</button>
								</form>
							</footer>
						<?php 
						} 
					?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	
	<div class="block full_block" data-task="fac" style="display:none">
		<div class="pannel pannel_body pannel_title">
			<h2>Vos paiements (<?php echo count($invoices) ?>)</h2>
			<!-- <p class="legend"><button class="button_legend">Pour plus d'informations, veuillez nous contacter</button></p> -->
		</div>
		<div class="pannel pannel_body container_to_table">
			<table class="table_fac">
				<thead>
					<tr>
						<th>Id facture</th>
						<th>Désignation</th>
						<th>Montant (ttc)</th>
						<th>Date</th>
						<th>PDF</th>
					</tr>
				</thead>
				<tbody>
					<?php if($invoices): foreach ($invoices as $key => $invoice): ?>
						<tr>
							<td>FA-MC-<?php echo explode('-', $invoice['date_created'])[1]. explode('-',$invoice['date_created'])[2].'-'. $invoice['id_payment'] ?></td>
							<td><?php echo $invoice['designation'] ?></td>
							<td><?php echo $invoice['amount'] ?>€</td>
							<td><?php echo $invoice['date_created'] ?></td>
							<td><i data-adress="<?php echo $_SESSION['user']['adress']?>" data-facture="<?php echo $_SESSION['user']['societe'] ?>" class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
						</tr>
					<?php endforeach;endif ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php } ?>
</div>
		
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
	echo '<script>var apiList = '.$api_available.';</script>';
?>