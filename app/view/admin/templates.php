<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_template_admin">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-verti-center row-hori-between">
				<div>
					<h1>Templates</h1>
				</div>
				<button data-popup-template class="button_default button_primary">Ajouter un template</button>
			</div>
		</div>
	</div>
	<div class="block full_block"> 
		<div class="pannel pannel_body">
			<div class="col nowrap">
				<div class="row row-verti-center nowrap line_custom_search_template">
					<span class="text_additional">Templates</span>
					<div class="select-wrapper">
						<select class="select_default button_primary" data-select-template id="selectDisplayType">
							<option value="false">Public</option>
							<option value="true">Perso</option>
						</select>
					</div>
					<span class="text_additional">Utilisateur : </span>
					<div class="select-wrapper">
						<select class="select_default button_primary"  data-select-template id="selectDisplayUser">
							<option value="false">Selectionner un utilisateur</option>
							<?php foreach ($users as $key => $user): ?>
								<option value="<?= $user['user_id'] ?>"><?php echo htmlspecialchars($user['first_name']).' '.htmlspecialchars($user['last_name']); ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body list_template">
			<ul class="row wrap">
				<?php foreach ($templatePublic as $key => $tp): ?>
					<li style="background: url('<?= $pathToPublicTemplate.'template_public_'.$tp['id_template'].'/thumbnails/thumbnail.png'; ?>');" data-popup-preview>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<div class="popup_mc" id="addTemplatePublic">
		<div class="popup_background"></div>
		<div class="popup_container">
			<header>
				<h1>AJOUTER UN TEMPLATE PUBLIC</h1>
			</header>
			<form method="post" action="?module=admin&action=templates" class="active" id="formAddTemplate" enctype="multipart/form-data">
				<div class="content_block popup-blocks">
					<div>
						<div class="field">
							<div class="oneside aside">
								<label for="templateName">Nom du template :*</label>
							</div>
							<div class="overside aside">
								<p>
									<input type="text" autocomplete="off" spellcheck="false" name="templateName" id="templateName" placeholder="" required="required">
								</p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label for="templateDOM">DOM :*</label>
							</div>
							<div class="overside aside">
								<p>
									<textarea name="templateDOM" autocomplete="off" spellcheck="false" id="templateDOM" required="required"></textarea>
								</p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label for="templateQuery">Query :*</label>
							</div>
							<div class="overside aside">
								<p>
									<textarea name="templateQuery" autocomplete="off" spellcheck="false" id="templateQuery" required="required"></textarea>
								</p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label for="templateImg">Image :*</label>
							</div>
							<div class="overside aside">
								<p>
									<input type="file" accept="application/zip" name="templateImg" id="templateImg" required="required">
								</p>
							</div>
						</div>
					</div>
				</div>
				<footer class="row row-hori-center">
					<button type="submit" class="button_default button_secondary">Prévisualiser</button>
				</footer>
			</form>
		</div>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>
