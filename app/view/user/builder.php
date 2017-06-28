<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_builder">
	<div class="block full_block">
		<div class="container_left col nowrap">
			<div id="storage_template" style="display: none;"><?php echo htmlspecialchars_decode(html_entity_decode($template[0]['DOM'])); ?></div>
			<div id="storage_medias" style="display: none;"><?php echo htmlspecialchars_decode(html_entity_decode($template[0]['medias'])); ?></div>
			<div id="storage_email_to_export" style="display: none"></div>

			<header class="header_builder row row-verti-center row-hori-between nowrap">
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
					<input type="text" spellcheck="false" autocomplete="off" onpaste="return false;" value="<?= $mail[0]['email_background'];?>" id="background_email" class="choose_color_background" />
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