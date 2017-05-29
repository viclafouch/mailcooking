<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div>
	<div class="nwrap">
		<h1>Tableau de bord admin</h1>
	</div>
	<ul>
		<li><a href="?module=admin&action=users" title="">Les utilisateurs</a></li>
		<li><a href="?module=admin&action=commandes" title="">Les commandes</a></li>
	</ul>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>