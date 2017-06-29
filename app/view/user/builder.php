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
				<input id="documentTitle" spellcheck="false" placeholder="Nom de l'email" autocomplete="off" value='<?= htmlspecialchars($mail[0]['email_name']); ?>' type="text" onpaste="return false;" required>
				<?php } ?>
				<div class="tools_primary row wrap row-verti-center">
					<input type="text" spellcheck="false" autocomplete="off" onpaste="return false;" value="<?= $mail[0]['email_background'];?>" id="background_email" class="choose_color" />
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
				<span id="items_sidebar" data-menu class="active">Items</span>
				<span id="thumbnails_sidebar" data-menu >Sections</span>
			</header>
			<div class="content_sidebar">
				<div class="task_sidebar" data-task="items_sidebar">
					<div class="col nowrap">
						<div id="background-color" class="field_item_sidebar" data-display-spacer data-display-text data-display-cta>
							<div class="col nowrap">
								<label>Couleur de fond</label>
								<div class="item">
									<input type="text" value="#ffffff" class="choose_color" />
								</div>
							</div>
						</div>
						<div id="color" class="field_item_sidebar" data-display-text data-display-cta>
							<div class="col nowrap">
								<label>Couleur de police</label>
								<div class="item">
									<input type="text" value="#ffffff" class="choose_color" />
								</div>
							</div>
						</div>
						<div id="font-family" class="field_item_sidebar" data-display-text data-display-cta>
							<div class="col nowrap">
								<label>Police</label>
								<select>
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
								<input type="url" spellcheck="false" autocomplete="off" type="url" class="input" placeholder="http://">
							</div>
						</div>
						<div id="height" class="field_item_sidebar" data-display-spacer>
							<div class="col nowrap">
								<label>Hauteur <span class="unity">(en px)</span></label>
								<div class="item">
									<input type="text" id="height" value="" class="change_number" data-change='height' data-max="150" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="20" />	
								</div>
							</div>
						</div>
						<div id="font-size" class="field_item_sidebar" data-display-text data-display-cta>
							<div class="col nowrap">
								<label>Taille de police <span class="unity">(en px)</span></label>
								<div class="item">
									<input type="text" id="font-size" value="" class="change_number" data-change='font-size' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="6" />	
								</div>
							</div>
						</div>
						<div id="line-height" class="field_item_sidebar" data-display-text>
							<div class="col nowrap">
								<label>Interlignage <span class="unity">(en px)</span></label>
								<div class="item">
									<input type="text" id="line-height" value="" class="change_number" data-change='line-height' data-max="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="" />	
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
												<input type="text" id="padding-top" value="" class="change_number" data-change='padding-top' data-max="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
									<div class="map_block">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" id="padding-left" value="" class="change_number" data-change='padding-left' data-max="80" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
										</div>
									</div>
									<div class="map_block map_block_center center">
										<p>Section</p>
									</div>
									<div class="map_block">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" id="padding-right" value="" class="change_number" data-change='padding-right' data-max="80" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
									<div class="map_block center">
										<div class="flipper">
											<div class="map_block_number flipper_front">
												<input type="text" id="padding-bottom" value="" class="change_number" data-change='padding-bottom' data-max="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
								</div>
							</div>
						</div>
						<div id="border" class="field_item_sidebar" data-display-text>
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
												<input type="text" id="border-top-width" value="" class="change_number" data-change='border-top-width' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
											<div class="map_block_color flipper_back">
												<input type="text" spellcheck="false" autocomplete="off" value="#ffffff" class="choose_color" />
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
												<input type="text" id="border-bottom-width" value="" class="change_number" data-change='border-bottom-width' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
											</div>
											<div class="map_block_color flipper_back">
												<input type="text" spellcheck="false" autocomplete="off" value="#ffffff" class="choose_color" />
											</div>
										</div>
									</div>
									<div class="map_block notvisible"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="task_sidebar" data-task="thumbnails_sidebar">
				</div>
			</div>
		</div>
	</div>
</div>
	<!-- <div class="popup_overlay"></div>
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
	</div> -->
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>

	<!-- <div class="popup_overlay"></div>
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
	</div> -->
<!-- 	<div class="sidebar_tools">
		<div class="container-fluid col menu">
			<header class="tools_menu_email_block verhor-center">
				<span id="items_builder" class="btn_menu_builder active">Items</span>
				<span id="sections_builder" class="btn_menu_builder">Sections</span>
			</header>
			<div class="items_builder_block task">
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
						<input type="text" id="height" value="" class="input btn_tools change_value" data-change='height' data-max="150" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="20" />
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
						<input type="text" id="fontSize" value="" class="input btn_tools change_value" data-change='font-size' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="6" />
					</div>
				</div>
				<div class="field_tools_item_block verhor-center line-height" data-display-text>
					<div class="item col">
						<label>Interlignage <span class="taille">(en px)</span></label>
						<input type="text" id="lineHeight" value="" class="input btn_tools change_value" data-change='line-height' data-max="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="" />
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
									<input type="text" id="paddingTop" value="" class="change_value" data-change='padding-top' data-max="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
								</div>
								<div class="block none"></div>
							</div>
							<div class="row">
								<div class="block" id="padding-left">
									<input type="text" id="paddingLeft" value="" class="change_value" data-change='padding-left' data-max="80" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
								</div>
								<div class="center block">
									<p>Section</p>
								</div>
								<div class="block" id="padding-right">
									<input type="text" id="paddingRight" value="" class="change_value" data-change='padding-right' data-max="80" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
								</div>
							</div>
							<div class="row">
								<div class="block none"></div>
								<div class="block" id="padding-bottom">
									<input type="text" id="paddingBottom" value="" class="change_value" data-change='padding-bottom' data-max="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
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
											<input type="text" id="borderTop" value="" class="change_value" data-change='border-top-width' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
										</div>
										<div class="back">
											<input type="text" value="#ffffff" class="choose_color_border" />
										</div>
									</div>
								</div>
								<div class="block none"></div>
							</div>
							<div class="row">
								<div class="block none"></div>
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
											<input type="text" id="borderBottom" value="" class="change_value" data-change='border-bottom-width' data-max="20" onkeypress='return event.charCode >= 48 && event.charCode <= 57' data-min="0" />
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
			<div class="menuactive task todo container-fluid">
				<div class="col nowrap col-hori-center">
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
						<polygon style="fill:#65D3AF;" points="288.353,255.243 288.353,85.081 212.725,85.081 212.725,113.441 241.086,113.441 
							241.086,132.348 212.725,132.348 212.725,151.255 241.086,151.255 241.086,170.162 212.725,170.162 212.725,189.069 
							241.086,189.069 241.086,207.976 212.725,207.976 212.725,255.243 "/>
						<circle style="fill:#E5D85A;" cx="118.191" cy="425.405" r="9.453"/>
						<path style="fill:#C59981;" d="M278.262,322.931c-5.89,0-12.011,0.354-18.27,0.954v35.346c0,5.225-4.228,9.453-9.453,9.453
							c-5.225,0-9.453-4.228-9.453-9.453V326.53c-16.552,2.975-33.904,7.729-51.532,14.283l-9.149,3.397l-3.111-9.25
							c-6.398-19.027-20.735-31.979-34.583-31.979c-1.385,0-2.77,0.129-4.136,0.397c-7.995,1.551-14.836,7.515-19.258,16.774
							c-4.884,10.21-6.185,22.941-3.684,35.838c0.757,3.859,1.837,7.644,3.222,11.235l2.742,7.099l-6.342,4.191
							c-43.686,28.868-63.239,55.899-63.239,69.876c0,40.066,106.453,44.701,186.521,44.701c110.303,0,172.71-2.714,172.71-58.484
							C411.248,383.658,388.177,322.931,278.262,322.931z M118.191,453.765c-15.639,0-28.36-12.721-28.36-28.36
							c0-15.639,12.722-28.36,28.36-28.36s28.36,12.721,28.36,28.36C146.551,441.044,133.83,453.765,118.191,453.765z"/>
						<g>
							<path style="fill:#314E55;" d="M118.191,397.045c-15.639,0-28.36,12.721-28.36,28.36c0,15.639,12.722,28.36,28.36,28.36
								s28.36-12.721,28.36-28.36C146.551,409.766,133.83,397.045,118.191,397.045z M118.191,434.858c-5.216,0-9.453-4.238-9.453-9.453
								c0-5.216,4.238-9.453,9.453-9.453c5.216,0,9.453,4.238,9.453,9.453C127.644,430.621,123.407,434.858,118.191,434.858z"/>
							<path style="fill:#314E55;" d="M426.637,234.961c-41.239-46.575-55.973-86.863-42.624-116.516
								c12.998-28.868,49.732-41.359,65.602-41.359c5.225,0,9.453-4.228,9.453-9.453s-4.228-9.453-9.453-9.453
								c-23.874,0-66.71,16.682-82.838,52.502c-11.605,25.757-13.091,70.402,45.698,136.816c37.86,42.762,53.563,77.419,45.421,100.231
								c-7.546,21.158-34.342,27.376-39.053,28.321c-16.392-37.538-54.778-72.024-140.581-72.024c-5.907,0-12.043,0.37-18.27,0.919V274.15
								h47.267V85.081h28.36c5.225,0,9.453-4.228,9.453-9.453s-4.228-9.453-9.453-9.453h-28.36h-47.267V18.907h75.628
								c5.225,0,9.453-4.228,9.453-9.453S340.845,0,335.62,0H165.458c-5.225,0-9.453,4.228-9.453,9.453s4.228,9.453,9.453,9.453h75.628
								v47.267h-47.267h-28.36c-5.225,0-9.453,4.228-9.453,9.453s4.228,9.453,9.453,9.453h28.36V274.15h47.267v33.287
								c-15.976,2.661-32.568,6.766-49.464,12.558c-11.808-24.972-34.527-39.485-56.647-35.173c-14.032,2.723-25.655,12.371-32.718,27.179
								c-6.619,13.848-8.456,30.751-5.179,47.6c0.471,2.428,1.052,4.847,1.726,7.21c-41.276,28.517-65.694,58.724-65.694,81.582
								c0,55.899,98.735,63.608,205.428,63.608c102.815,0,191.617,0,191.617-77.391c0-12.081-1.219-26.189-5.048-40.579
								c10.913-2.575,40.521-11.965,50.552-39.812C486.506,324.085,470.018,283.963,426.637,234.961z M212.725,207.976h28.36v-18.907
								h-28.36v-18.907h28.36v-18.907h-28.36v-18.907h28.36v-18.907h-28.36v-28.36h75.628v170.162h-75.628V207.976z M238.538,493.093
								c-80.068,0-186.521-4.634-186.521-44.701c0-13.977,19.553-41.008,63.238-69.876l6.342-4.191l-2.742-7.099
								c-1.385-3.591-2.465-7.376-3.222-11.235c-2.502-12.897-1.2-25.628,3.684-35.838c4.422-9.26,11.263-15.223,19.258-16.774
								c1.366-0.268,2.751-0.397,4.136-0.397c13.848,0,28.185,12.952,34.583,31.979l3.111,9.25l9.149-3.397
								c17.629-6.554,34.981-11.308,51.532-14.283v32.701c0,5.225,4.228,9.453,9.453,9.453c5.225,0,9.453-4.228,9.453-9.453v-35.345
								c6.259-0.601,12.379-0.954,18.27-0.954c109.915,0,132.985,60.727,132.985,111.678C411.248,490.379,348.84,493.093,238.538,493.093z
								"/>
						</g>
					</svg>
					<p>Clic sur un élement de l'email pour le personnaliser</p>
				</div>
			</div>
		</div>
	</div> -->