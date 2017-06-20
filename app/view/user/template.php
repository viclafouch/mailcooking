<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<?php if (isset($_GET["notif"])): ?>
		<?php if ($_GET["notif"] == "ok"): ?>
			<div class="alert"><p>Commande envoyé !</p></div>
		<?php endif ?>
<?php endif ?>

<div class="container container_template">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-hori-between row-verti-center">
				<div>
					<h1>Mes templates</h1>
				</div>
				<div class="row row-verti-center nowrap">
					<button data-popup-order class="button_default button_primary">Commander un template</button>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block"> 
		<div class="pannel pannel_body">
			<div class="col nowrap">
				<div class="row row-verti-center nowrap line_custom_search_template">
					<span class="text_additional">Templates</span>
					<div class="select-wrapper">
						<select class="select_default button_primary" data-select-template id="selectDisplayAllow">
							<?php if (!$public) { ?>
								<option selected="selected" value="1">Perso</option>
								<option value="0">Public</option>
							<?php } else { ?>
								<option selected="selected" value="0">Public</option>
								<option value="1">Perso</option>
							<?php } ?>
						</select>
					</div>
					<span class="text_additional">Trié par</span>
					<div class="select-wrapper">
						<select class="select_default button_primary"  data-select-template id="selectDisplayDate">
							<option selected="selected" value="1">Les plus récents</option>
							<option value="0">Les plus anciens</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body list_template">
			<ul class="col nowrap">
			<?php foreach ($template as $key => $temp) { ?>
			<?php 
				// Compter le nombre de mails utilisés par le template
				$options = array ("wherecolumn" => "template_id", 
									"wherevalue" => $temp['id_template']);
				$countMailsEditor = counttable("mail_editor", $options);
			?>
				<li class="row nowrap row-hori-between li_template" data-allow="<?php if ($temp['id_allow'] == 'all') { ?>0<?php } else { ?>1<?php } ?>" data-template="<?= $temp['id_template']; ?>">
					<div class="row nowrap">
						<div class="col nowrap col_template_thumbs">
							<img data-popup-preview src="http://via.placeholder.com/120x170" alt="">
						</div>
						<div class="col nowrap col_template_descr">
							<p class="title_row"><span class="title_template" contenteditable="false" onpaste="return false;" spellcheck="false"><?= $temp['title_template']?></span>&nbsp;</p>
							<div class="info_template">
								<p>Template <?php if ($temp['id_allow'] == 'all') { ?>
									public <i class="material-icons">public</i>
								<?php } else { ?>
									perso <i class="material-icons">perm_identity</i>
								<?php } ?>
								</p>
								<p><strong>Commande terminée</strong> le 24 Mai 2016</p>
								<p>Utilisé actuellement dans <strong><?= $countMailsEditor; ?></strong> email<?php if ($countMailsEditor > 1) { ?>s
								<?php } ?></p>
							</div>
						</div>
					</div>
					<div class="col nowrap">
						<div class="row wrap row-verti-center row-hori-between row_actions_template">
							<button class="button_default button_secondary">Créer un email</button>
							<button data-action-template class="button_default button_secondary"><i class="material-icons data-action-template">expand_more</i></button>
						</div>
						<div class="popup_action_template">
							<ul class="col nowrap">
								<li data-popup-preview>Prévisualiser</li>
								<?php if ($temp['id_allow'] != 'all'): ?>
								<li>Demander une modification</li>
								<li>Supprimer</li>	
								<?php endif ?>
							</ul>
						</div>
					</div>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
	<div class="popup_mc" id="templatePreview">
		<div class="popup_background"></div>
		<div class="popup_container"></div>
	</div>
	<div class="popup_mc" id="templateOrder">
		<div class="popup_background"></div>
		<div class="popup_container">
			<header>
				<h1>CR&Eacute;ER UN TEMPLATE</h1>
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
									<input type="text" autocomplete="off" spellcheck="false" name="nom_commande" id="nom_commande" placeholder="" required="required">
								</p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label for="commentaire_commande">Commentaire :*</label>
							</div>
							<div class="overside aside">
								<p>
									<textarea name="commentaire_commande" autocomplete="off" spellcheck="false" id="commentaire_commande" required="required"></textarea>
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
					<button type="submit" class="button_default button_secondary">Envoyer ma commande</button>
				</footer>
			</form>
		</div>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>