<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<?php if (isset($_GET["notif"])): ?>
		<?php if ($_GET["notif"] == "ok"): ?>
			<div class="notif"><img src="webroot/img/checked.png" title="" alt=""></div>
		<?php endif ?>
<?php endif ?>
 <div class="templates">
	<div class="nwrap">
		<h1>Mes Templates</h1>
		<button class="action_creat_temp button_default">
			<span class="buttoneffect"></span>
			<span class="text-cta">Créer un template</span>
		</button>
	</div>
	<div class="each-container-templates perso">
		<h3>Public</h3>
		<div class="row_list_template">
			<?php foreach ($template as $key => $temp) { ?>
				<?php if ($temp['id_allow'] == "all"): ?>
					<div class="block template_block see_template" id="<?= $temp['id_template']; ?>">
						<p>Public</p>
					</div>
					<?php endif ?>
			<?php } ?>
		</div>
	</div>
	<div class="each-container-templates public">
		<h3>Perso</h3>
		<div class="row_list_template">
			<?php foreach ($template as $key => $temp) { ?>
				<?php if ($temp['id_allow'] == $_SESSION["user"]["user_id"]): ?>
					<div class="block template_block see_template" id="<?= $temp['id_template']; ?>">
						<p>Perso</p>
					</div>
					<?php endif ?>
			<?php } ?>
		</div>
	</div>
</div>

<div class="popup-overlay creat_template"></div>
<div class="popup-container creat_template">
	<header>
		<h1>CR&Eacute;E UN TEMPLATE</h1>
	</header>
	<form method="post" action="?module=user&action=template" enctype="multipart/form-data">
		<div class="content_block popup-blocks">
			<div>
				<div class="field">
					<div class="oneside aside">
						<label for="nom_commande">Nom de ma commande :*</label>
					</div>
					<div class="overside aside">
						<p>
							<input type="text" name="nom_commande" id="nom_commande" placeholder="" required="required">
						</p>
					</div>
				</div>
				<div class="field">
					<div class="oneside aside">
						<label for="commentaire_commande">Commentaire :*</label>
					</div>
					<div class="overside aside">
						<p>
							<textarea name="commentaire_commande" id="commentaire_commande" required="required"></textarea>
						</p>
					</div>
				</div>
				<div class="field">
					<div class="oneside aside">
						<label for="file_commande">Maquettes :*</label>
					</div>
					<div class="overside aside">
						<p>
							<input type="file" name="file_commande" id="file_commande" required="required">
						</p>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<div>
				<button type="submit" class="button_default">
					<span class="buttoneffect"></span>
					<span class="text-cta">Envoyer ma commande</span>
				</button>
			</div>
		</footer>
	</form>
</div>

<a href='' class="creat_email" data-turbolinks="false" title="">Créer un email</a>
<div class="popup-container template_email">
	<div class="see_email_template_block"></div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>