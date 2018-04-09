<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_emails">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-hori-between row-verti-center">
				<div>
					<h1>Mes emails</h1>
				</div>
				<div class="row row-verti-center nowrap">
					<a href="?module=user&action=archives" class="button_default button_primary button_href">Archives</a>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body" data-list-emails data-allow="0">
			<div class="col nowrap">
				<div class="pannel_title row row-hori-between row-verti-center">
					<h2>Emails non classés</h2>
					<div class="row nowrap">
						<button data-select-email="all" class="selection button_default button_secondary active"><i class="material-icons">playlist_add_check</i>Tous</button>
						<button data-select-email="0" class="selection button_default button_secondary"><i class="material-icons">create</i>Brouillons</button>
						<button data-select-email="1" class="selection button_default button_secondary"><i class="material-icons">done</i>Emails terminés</button>		
					</div>
				</div>
				<div class="pannel_body">
					<ul class="row row-verti-center emails_list">
						<?php $notempty = false; ?>
						<?php foreach ($emails as $email): ?>
							<?php if ($email["email_cat_id"] == NULL && $email["saved"] != 0) {
								$notempty = true;
								$timestamp = new DateTime($email['timestamp']);
								$emailDate = $timestamp->format('d-m-Y');

								$folder = ''.$email['id_mail'].'_'.$emailDate.'/';
								$src = $chemin.'emails/'.$folder;
							?>

								<li style="background: url('<?= $src; ?>thumbs.png');" class="email" data-email="<?= $email["id_mail"]; ?>" data-status="<?php echo $email["as_campaign"]; ?>">
									<div data-toolbox class="row nowrap row-verti-center row-hori-center toolbox_email"></div>
									<span class="badge <?php if ($email["as_campaign"] == 1) { echo 'campaign'; }else{ echo 'saved';} ?>"></span>
								</li>
							<?php } ?>
						<?php endforeach ?>
						<?php if (!$notempty): ?>
							<div class="empty_list_emails"><p>Aucun emails non classé</p></div>
						<?php endif ?>
					</ul>
				</div>
			</div>
		</div>
		<?php foreach ($userCat as $key => $cat): ?>
		<div class="pannel pannel_body" data-list-emails data-section="<?= $cat['cat_id'] ;?>" data-allow="1">
			<div class="col nowrap">
				<div class="pannel_title row row-verti-center">
					<p>
						<span spellcheck="false" onpaste="return false" class="title_row"><?= $cat['cat_name']; ?></span>
					</p>
				</div>
				<div class="pannel_body">
					<ul class="row row-verti-center emails_list">
						<?php foreach ($emails as $email): ?>
							<?php if ($cat['cat_id'] == $email['email_cat_id'] && $email["saved"] != 0) {

								$timestamp = new DateTime($email['timestamp']);
								$emailDate = $timestamp->format('d-m-Y');

								$folder = ''.$email['id_mail'].'_'.$emailDate.'/';
								$src = $chemin.'emails/'.$folder;
							?>
								<li style="background: url('<?= $src; ?>thumbs.png');" class="email" data-email="<?= $email["id_mail"]; ?>" data-status="<?php echo $email["as_campaign"]; ?>">
									<div data-toolbox class="row nowrap row-verti-center row-hori-center toolbox_email"></div>
									<span class="badge <?php if ($email["as_campaign"] == 1) { echo 'campaign'; }else{ echo 'saved';} ?>"></span>
								</li>
							<?php } ?>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
		</div>
		<?php endforeach ?>
		<div class="pannel pannel_body" id="pannelAddSection">
			<div class="col nowrap">
				<div class="col col-verti-center col-hori-center nowrap add_section">
					<div class="flipper">
						<div id="newCatFlipper" class="flipper_front row row-hori-center row-verti-center">
							<p>Ajouter une section</p>
						</div>
						<div class="flipper_back row row-hori-center row-verti-center">
							<span id="closedFlipper"><i class="material-icons">close</i></span>
							<form method="post" action="" class="col col-verti-center">
								<input type="text" spellcheck="false" autocomplete="off" id="inputCatFlipper" placeholder="Nom de la section" />
								<button type="submit" id="saveCatFlipper" class="button_default">Ajouter</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="popup_mc" id="deleteCatConfirmation">
		<div class="popup_background"></div>
		<div class="popup_container">
			<header>
				<h1>SUPPRIMER LA CATEGORIE ?</h1>
			</header>
			<div class="content_block popup-blocks col col-hori-center col-verti-center nowrap">
				<p><u>Attention</u> : Cette action supprimera tous les emails/archives liés à cette catégorie !<p>
			</div>
			<footer class="col col-hori-center col-verti-center nowrap">
				<button data-close-popup class="button_default button_secondary">Supprimer</button>
				<span data-close-popup>Annuler</span>
			</footer>
		</div>
	</div>
	<div class="popup_mc" id="deleteEmailConfirmation">
		<div class="popup_background"></div>
		<div class="popup_container">
			<header>
				<h1>SUPPRIMER L'EMAIL ?</h1>
			</header>
			<div class="content_block popup-blocks col col-hori-center col-verti-center nowrap">
				<p>Vous avez le choix entre <u>supprimer définitivement</u> l'email, ou le <u>placer en archive</u>.</p>
			</div>
			<footer class="row row-hori-center row-verti-center nowrap">
				<button data-close-popup data-delete-forever class="button_default button_secondary">Supprimer</button>
				<button data-close-popup data-delete-archive class="button_default button_secondary">Archiver</button>
			</footer>
		</div>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>