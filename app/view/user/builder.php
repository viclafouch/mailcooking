<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container_builder">
	<div class="popup_overlay"></div>
	<div class="popup_container" id="popupExport">
		<div class="download_icon" id="downloading">
			<svg width="180" height="178">
				<g transform="scale(5) translate(0,0)" style="cursor: pointer;" >
				<circle class="outer_circle" cx="175" cy="20" r="14" transform="rotate(-90, 95, 95)"/>
				<g><path style="stroke:none;stroke-opacity:1;fill-opacity:1"
				d="m 15,14.013038 c -0.288333,-0.296648 -0.120837,-0.785812 0.379028,-0.785812 0.65373,0 1.306936,0 1.960405,0 0,-2.427829 0,-4.855658 0,-7.283712 0,-0.250992 0.244035,-0.4603768 0.536562,-0.4603768 1.450579,0 2.900896,0 4.350688,0 0.292527,0 0.536563,0.2093848 0.536563,0.4603768 0,2.428054 0,4.855883 0,7.283712 0.653468,0 1.306674,0 1.960405,0 0.499865,0 0.667361,0.489164 0.379027,0.785812 -1.557262,1.605358 -3.114787,3.210716 -4.67205,4.816075 -0.114285,0.118072 -0.249277,0.160801 -0.379288,0.153158 -0.130013,0.0077 -0.264481,-0.03531 -0.37929,-0.153158 -1.557263,-1.605359 -3.114787,-3.210717 -4.67205,-4.816075 z" />
				<rect y="22" x="13" height="0.17780706" width="14" style="opacity:1;fill-opacity:1;fill-rule:evenodd;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" />
				</g>
			</svg>  
		</div>
		<p>Cliquez sur le bouton ci-dessus pour démarrer le téléchargement de l'export</p>
	</div>
	<div class="content_email">
		<div class="header">
			<input id="documentTitle" spellcheck="false" placeholder="Nom de l'email" autocomplete="off" value='<?= $user[0]['email_name']; ?>' type="text" required>
			<div id="loader_saving">
				
			</div>
			<div class="tools_primary row wrap row-verti-center">
				<input type="text" value="<?= $user[0]['email_background'];?>" id="background_email" class="choose_color_background" />
				<button class="clic icon-action" id="undo"><i class="material-icons">undo</i></button>
				<button class="clic icon-action" id="redo"><i class="material-icons">redo</i></button>
				<span class="icon-action clic text-gris" id="mobileView"><i class="material-icons">phone_iphone</i></span>
				<span class="icon-action clic text-gris" id="saveDocument"><i class="material-icons">save</i></span>						
				<span class="icon-action clic text-gris" id="exportDocument"><i class="material-icons">file_download</i></span>
			</div>
		</div>
		<div class="edit_img croppie_sleep" id="imgToCroppie">
		</div>
		<div id="storage_template" style="display: none;"><?php echo htmlspecialchars_decode(html_entity_decode($template[0]['DOM'])); ?></div>
		<div id="storage_medias" style="display: none;"><?php echo htmlspecialchars_decode(html_entity_decode($template[0]['medias'])); ?></div>
		<div id="storage_email" style="background-color: <?= $user[0]['email_background'];?>"><?php echo htmlspecialchars_decode(html_entity_decode($user[0]['email_dom'])); ?></div>
		<div id="storage_email_to_export" style="display: none"></div>	
	</div>
	<div class="sidebar_tools">
		<div class="container-fluid col menu">
			<header class="tools_menu_email_block verhor-center">
				<span id="items_builder" class="btn_menu_builder active">Items</span>
				<span id="sections_builder" class="btn_menu_builder">Sections</span>
			</header>
			<div class="items_builder_block task menuactive">
				<div class="field_tools_item_block verhor-center background-color" data-display-spacer data-display-text data-display-cta>
					<div class="item col">
						<label>Couleur de fond</label>
						<input type="text" value="#ffffff" class="choose_color" />
					</div>
				</div>
				<div class="field_tools_item_block verhor-center img" data-display-img>
					<div class="item col">
						<button id="active-croppie" class="croppie_sleep">Modifier l'image</button>
					</div>
				</div>
				<div class="field_tools_item_block verhor-center color" data-display-text data-display-cta>
					<div class="item col">
						<label>Couleur de police</label>
						<input type="text" value="#ffffff" class="choose_color" />
					</div>
				</div>
				<div class="field_tools_item_block verhor-center link" data-display-img data-display-cta>
					<div class="item col">
						<label>Lien de redirection</label>
						<input type="url" placeholder="http://" class="input" />
					</div>
				</div>
				<div class="field_tools_item_block verhor-center height" data-display-spacer>
					<div class="item col">
						<label>Hauteur  <span class="taille">(en px)</span></label>
						<input type="text" value="" class="input btn_tools change_value" data-change='height' data-max="150" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="20" />
						<span class="change_value_action btn_action_plus" id="plus" data-control='heigth'>
							<i class="signe material-icons">add</i>
						</span>
						<span class="change_value_action btn_action_moins" id="moins" data-control='heigth'>
							<i class="signe material-icons">remove</i>
						</span>
					</div>
				</div>
				<div class="field_tools_item_block verhor-center font-family" data-display-text data-display-cta>
					<div class="item col">
						<label>Police</label>
						<select class="input btn_tools">
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
				<div class="field_tools_item_block verhor-center font-size" data-display-text data-display-cta>
					<div class="item col">
						<label>Taille de la police <span class="taille">(en px)</span></label>
						<input type="text" value="48" class="input btn_tools change_value" data-change='font-size' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="6" />
						<span class="change_value_action btn_action_plus" id="plus" data-control='font-size'>
							<i class="signe material-icons">add</i>
						</span>
						<span class="change_value_action btn_action_moins" id="moins" data-control='font-size'>
							<i class="signe material-icons">remove</i>
						</span>
					</div>
				</div>
				<div class="field_tools_item_block verhor-center line-height" data-display-text>
					<div class="item col">
						<label>Interlignage <span class="taille">(en px)</span></label>
						<input type="text" value="" class="input btn_tools change_value" data-change='line-height' data-max="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="" />
						<span class="change_value_action btn_action_plus" id="plus" data-control='line-height'>
							<i class="signe material-icons">add</i>
						</span>
						<span class="change_value_action btn_action_moins" id="moins" data-control='line-height'>
							<i class="signe material-icons">remove</i>
						</span>
					</div>
				</div>
				<div class="field_tools_item_block verhor-center text-align" data-display-text>
					<div class="item col">
						<label>Alignement</label>
						<p>
							<span id="left" class="format_align"><i class="material-icons">format_align_left</i></span>
							<span id="center" class="format_align"><i class="material-icons">format_align_center</i></span>
							<span id="right" class="format_align"><i class="material-icons">format_align_right</i></span>
							<span id="justify" class="format_align"><i class="material-icons">format_align_justify</i></span>
						</p>
					</div>
				</div>
				<div class="field_tools_item_block verhor-center padding" data-display-text>
					<div class="item col">
						<label>Padding <span class="taille">(en px)</span></label>
						<div class="map_block">
							<div class="row">
								<div class="block none"></div>
								<div class="block" id="padding-top">
									<div class="number">
										<input type="text" class="change_value" data-change='padding-top' data-max="100" data-min="0" placeholder="..." value="6" name=""/>
									</div>
									<div class="action_number">
										<span class="btn_action_plus" data-control='padding-top'><i class="signe material-icons">add</i></span>
										<hr>
										<span class="btn_action_moins" data-control='padding-top'><i class="signe material-icons">remove</i></span>
									</div>
								</div>
								<div class="block none"></div>
							</div>
							<div class="row">
								<div class="block" id="padding-left">
									<div class="number">
										<input type="text" class="change_value" data-change='padding-left' data-max="80" data-min="0" placeholder="..." value="6" name=""/>
									</div>
									<div class="action_number">
										<span class="btn_action_plus" data-control='padding-left'><i class="signe material-icons">add</i></span>
										<hr>
										<span class="btn_action_moins" data-control='padding-left'><i class="signe material-icons">remove</i></span>
									</div>
								</div>
								<div class="center block">
									<p>Section</p>
								</div>
								<div class="block" id="padding-right">
									<div class="number">
										<input type="text" class="change_value" data-change='padding-right' placeholder="..." data-max="80" data-min="0" value="6" name=""/>
									</div>
									<div class="action_number">
										<span class="btn_action_plus" data-control='padding-right'><i class="signe material-icons">add</i></span>
										<hr>
										<span class="btn_action_moins" data-control='padding-right'><i class="signe material-icons">remove</i></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="block none"></div>
								<div class="block" id="padding-bottom">
									<div class="number">
										<input type="text" class="change_value" data-change='padding-bottom' data-max="100" data-min="0" placeholder="..." value="6" name=""/>
									</div>
									<div class="action_number">
										<span class="btn_action_plus" data-control='padding-bottom'><i class="signe material-icons">add</i></span>
										<hr>
										<span class="btn_action_moins" data-control='padding-bottom'><i class="signe material-icons">remove</i></span>
									</div>
								</div>
								<div class="block none"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="field_tools_item_block verhor-center border" data-display-spacer data-display-text data-display-img data-display-cta>
					<div class="item col">
						<label>Bordure <span class="taille">(en px)</span></label>
						<div class="map_block">
							<div class="change_action_border">
								<span class="btn_change_action_border active" id="change_size_border"><i class="material-icons">title</i></span>
								<span class="btn_change_action_border" id="change_color_border"><i class="material-icons">border_color</i></span>
							</div>
							<div class="row">
								<div class="block none"></div>
								<div class="block" id="border-top">
									<div class="flipper">
										<div class="front">
											<div class="number">
												<input type="text" class="change_value" data-change='border-top-width' data-min="0" data-max="20" placeholder="..." value="0" name=""/>
											</div>
											<div class="action_number">
												<span class="btn_action_plus" data-control='border-top'><i class="signe material-icons">add</i></span>
												<hr>
												<span class="btn_action_moins" data-control='border-top'><i class="signe material-icons">remove</i></span>
											</div>
										</div>
										<div class="back">
											<input type="text" value="#ffffff" class="choose_color_border" />
										</div>
									</div>
								</div>
								<div class="block none"></div>
							</div>
							<div class="row">
								<div class="block none"> </div>
								<div class="center block">
									<p>Section</p>
								</div>
								<div class="block none"></div>
							</div>
							<div class="row">
								<div class="block none"></div>
								<div class="block" id="border-bottom">
									<div class="flipper">
										<div class="front">
											<div class="number">
												<input type="text" class="change_value" data-change='border-bottom-width' data-min="0" data-max="20" placeholder="..." name=""/>
											</div>
											<div class="action_number">
												<span class="btn_action_plus" data-control='border-bottom'><i class="signe material-icons">add</i></span>
												<hr>
												<span class="btn_action_moins" data-control='border-bottom'><i class="signe material-icons">remove</i></span>
											</div>
										</div>
										<div class="back">
											<input type="text" value="#ffffff" class="choose_color_border" />
										</div>
									</div>
								</div>
								<div class="block none"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sections_builder_block task" id="thumbs">
			</div>
		</div>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>