<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="subs">
	<div class="nwrap">
		<h1>Abonnement</h1>
	</div>
</div>
<?php if ($premium == "premium") { ?>
<p>YOU ARE PREMIUM</p></br>
<a href="?module=user&action=unsub">Se désabonner</a>
<?php } else { ?>
<p><?= $premium; ?></p>
<form method="post" action="?module=user&action=buy">
	<input type="hidden" name="valide" value="go">
	<input type="submit" value="S'abonner">
</form>
<?php } ?>
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>