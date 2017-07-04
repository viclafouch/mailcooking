<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>
	
<div class="container container_dashboard_admin">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-hori-between row-verti-center">
				<div>
					<h1>Administration</h1>
				</div>
				<div class="row row-verti-center nowrap">
					<!-- <button class="button_default button_primary">Créer un email</button> -->
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block"> 
		<div class="pannel pannel_body">
			<p><a href="?module=admin&action=users" title="">Utilisateurs</a></p><br>
			<p><a href="?module=admin&action=commandes" title="">Commandes</a></p><br>
			<p><a href="?module=admin&action=templates" title="">Templates</a></p>
		</div>
	</div>
</div>


<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>