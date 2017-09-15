<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_orders">
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
