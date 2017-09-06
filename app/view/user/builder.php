<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_builder">
	<div class="block full_block row nowrap">
		<div class="container_left col nowrap">
			<div id="storage_template" style="display: none;"><?php echo htmlspecialchars_decode(html_entity_decode($template[0]['DOM'])); ?></div>
			<div id="storage_medias" style="display: none;"><?php echo htmlspecialchars_decode(html_entity_decode($template[0]['medias'])); ?></div>
			<div id="storage_email_to_export" style="display: none"></div>

			<header class="header_builder header_builder_left row row-verti-center row-hori-between nowrap">
				<?php if ($template[0]['statut'] == 0 && $_SESSION['user']['valide'] == 2) { ?>
					<div class="row row-hori-center">
						<span data-template="<?= $template[0]['id_template_commande']; ?>" class="btn_Test_template" id="valideTemplate"><i class="material-icons">done</i> <span>Valider</span></span>
						<span data-template="<?= $template[0]['id_template_commande']; ?>" class="btn_Test_template" id="cancelTemplate"><i class="material-icons">clear</i> <span>Annuler</span></span>
					</div>
					<input id="documentTitle" style="display: none;" value='<?= htmlspecialchars($mail[0]['email_name']); ?>'/>
				<?php } else { ?>
				<div class="row nowrap label_input">
					<input id="documentTitle" spellcheck="false" placeholder="Nom de l'email" autocomplete="off" value='<?= htmlspecialchars($mail[0]['email_name']); ?>' type="text" required>
					<?php if ($mail[0]['saved'] == 0) { ?>
					<p class="label_saved_name">Jamais sauvegardé</p>
					<?php } else { ?>
					<p class="label_saved_name">
						<?php if (is_null($mail[0]['saved_by'])) {
							echo "Jamais sauvegardé";
						} else {
							echo "Dernière modification effectuée par".htmlspecialchars($mail[0]['saved_by'])."";
						} ?>
					</p>
					<?php } ?>
				</div>
				<?php } ?>
				<div class="tools_primary row wrap row-verti-center">
					<input type="text" spellcheck="false" autocomplete="off" value="<?= $mail[0]['email_background'];?>" id="background_email" class="choose_color" />
					<button class="icon-action" id="undo"><i class="material-icons">undo</i></button>
					<button class="icon-action" id="redo"><i class="material-icons">redo</i></button>
					<span class="icon-action" id="mobileView"><i class="material-icons">phone_iphone</i></span>
					<span class="icon-action" id="saveDocument"><i class="material-icons">save</i></span>						
					<span class="icon-action" id="exportDocument"><i class="material-icons">file_download</i></span>
				</div>
			</header>
			<div class="content_email">
				<div id="storage_email" style="background-color: <?= $mail[0]['email_background'];?>"><?php echo htmlspecialchars_decode(html_entity_decode($mail[0]['email_dom'])); ?></div>
			</div>
			<div class="edit_img croppie_sleep" id="imgToCroppie"></div>			
		</div>
		<div class="container_right col nowrap">
			<header class="header_builder header_builder_right row nowrap">
				<span id="items_sidebar" class="active" data-menu>Items</span>
				<span id="thumbnails_sidebar" data-menu>Sections</span>
			</header>
			<div class="content_sidebar">
				<div class="task_sidebar" data-task="items_sidebar">
					<div class="col nowrap">
						<div id="background-color" class="field_item_sidebar" data-display-spacer data-display-text data-display-cta>
							<div class="col nowrap">
								<label>Couleur de fond</label>
								<div class="item">
									<input type="text" data-change="background-color" spellcheck="false" autocomplete="off" value="#ffffff" class="choose_color" />
								</div>
							</div>
						</div>
						<div id="color" class="field_item_sidebar" data-display-text data-display-cta>
							<div class="col nowrap">
								<label>Couleur de police</label>
								<div class="item">
									<input type="text" data-change="color" spellcheck="false" autocomplete="off" value="#ffffff" class="choose_color" />
								</div>
							</div>
						</div>
						<div id="font-family" class="field_item_sidebar" data-display-text data-display-cta>
							<div class="col nowrap">
								<label>Police</label>
								<select data-change="font-family">
									<option value="Arial" id="Arial">Arial</option>
									<option value="Open Sans" id="Open+Sans">Open Sans</option>
									<option value="Roboto" id="Roboto">Roboto</option>
									<option value="Lato" id="Lato">Lato</option>
									<option value='Montserrat' id="Montserrat">Montserrat</option>
									<option value="Lobster" id="Lobster">Lobster</option>
									<option value="Kaushan Script" id="Kaushan+Script">Kaushan Script</option>
								</select>
							</div>
						</div>
						<div id="link" class="field_item_sidebar" data-display-img data-display-cta>
							<div class="col nowrap">
								<label>Lien de redirection</label>
								<input spellcheck="false" autocomplete="off" type="url" class="input" data-change="link" placeholder="http://">
							</div>
						</div>
						<div id="height" class="field_item_sidebar" data-display-spacer data-display-img>
							<div class="col nowrap">
								<label>Hauteur <span class="unity">(en px)</span></label>
								<div class="item">
									<input type="text" value="" class="change_number" data-change='height' data-max="150" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="20" />	
								</div>
							</div>
						</div>
						<div id="font-size" class="field_item_sidebar" data-display-text data-display-cta>
							<div class="col nowrap">
								<label>Taille de police <span class="unity">(en px)</span></label>
								<div class="item">
									<input type="text" value="" class="change_number" data-change='font-size' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="6" />	
								</div>
							</div>
						</div>
						<div id="border-radius" class="field_item_sidebar" data-display-cta>
							<div class="col nowrap">
								<label>Contour de bordure <span class="unity">(en px)</span></label>
								<div class="item">
									<input type="text" value="" class="change_number" data-change='border-radius' data-max="25" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />	
								</div>
							</div>
						</div>
						<div id="line-height" class="field_item_sidebar" data-display-text>
							<div class="col nowrap">
								<label>Interlignage <span class="unity">(en px)</span></label>
								<div class="item">
									<input type="text" value="" class="change_number" data-change="line-height" data-max="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="" />	
								</div>
							</div>
						</div>
						<div id="text-align" class="field_item_sidebar" data-display-text>
							<div class="col nowrap">
								<label>Alignement <span class="unity">(en px)</span></label>
								<p class="item row nowrap">
									<span id="left" class="format_align"><i class="material-icons">format_align_left</i></span>
									<span id="center" class="format_align"><i class="material-icons">format_align_center</i></span>
									<span id="right" class="format_align"><i class="material-icons">format_align_right</i></span>
									<span id="justify" class="format_align"><i class="material-icons">format_align_justify</i></span>
								</p>	
							</div>
						</div>
						<div id="padding" class="field_item_sidebar" data-display-text>
							<div class="col nowrap">
								<label>Padding <span class="unity">(en px)</span></label>
								<div class="item map row wrap">
									<div class="map_block notvisible"></div>
									<div class="map_block center">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" value="" class="change_number" data-change='padding-top' data-max="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
									<div class="map_block">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" value="" class="change_number" data-change='padding-left' data-max="80" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
										</div>
									</div>
									<div class="map_block map_block_center center">
										<p>Section</p>
									</div>
									<div class="map_block">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" value="" class="change_number" data-change='padding-right' data-max="80" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
									<div class="map_block center">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" value="" class="change_number" data-change='padding-bottom' data-max="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
								</div>
							</div>
						</div>
						<div id="border" class="field_item_sidebar" data-display-spacer data-display-text data-display-img data-display-cta>
							<div class="col nowrap">
								<label>Bordure <span class="unity">(en px)</span></label>
								<div class="item map row wrap">
									<span class="widget_flipper active" data-flipper="front" data-item="border">
										<i class="material-icons">title</i>
									</span>
									<span class="widget_flipper" data-flipper="back" data-item="border">
										<i class="material-icons">border_color</i>
									</span>
									<div class="map_block notvisible"></div>
									<div class="map_block center">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" value="" class="change_number" data-change='border-top-width' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
											<div class="map_block_color flipper_back">
												<input type="text" spellcheck="false" autocomplete="off" value="#ffffff" data-change='border-top-color' class="choose_color" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
									<div class="map_block notvisible"></div>
									<div class="map_block map_block_center center">
										<p>Section</p>
									</div>
									<div class="map_block notvisible"></div>
									<div class="map_block notvisible"></div>
									<div class="map_block center">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" value="" class="change_number" data-change='border-bottom-width' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
											<div class="map_block_color flipper_back">
												<input type="text" spellcheck="false" data-change='border-bottom-color' autocomplete="off" value="#ffffff" class="choose_color" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
								</div>
							</div>
						</div>
						<div id="img" class="field_item_sidebar" data-display-img>
							<div class="col nowrap">
								<button data-change="img" class="button_default">Modifier l'image</button>
							</div>
						</div>
					</div>
				</div>
				<div class="task_sidebar" data-task="thumbnails_sidebar">
				</div>
				<div class="task_sidebar notask active" data-task="notask">
					<div>
						<?php include_once('webroot/img/builder/mouse.svg'); ?>
						<p>Clic sur un élement de l'email pour le personnaliser</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="popup_mc" id="popupCroppie">
		<div class="popup_background"></div>
		<div class="popup_container"></div>
	</div>

	<div class="popup_mc" id="popupExport">
		<div class="popup_background"></div>
		<div class="popup_container">
			<div class="cssload-thecube">
				<div class="cssload-cube cssload-c1"></div>
				<div class="cssload-cube cssload-c2"></div>
				<div class="cssload-cube cssload-c4"></div>
				<div class="cssload-cube cssload-c3"></div>
			</div>
			<p>Merci de patienter...</p>
		</div>
	</div>
</div>
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>