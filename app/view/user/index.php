<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_dashboard">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-hori-between row-verti-center">
				<div>
					<h1>Tableau de bord</h1>
				</div>
				<div class="row row-verti-center nowrap">
					<a class="button_default button_primary button_href" data-turbolinks="false" href="./">Quitter l'application</a>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body">
			<div class="row row-hori-between nowrap">
				<div class="sm_square col nowrap">
					<div class="square_body row row-hori-between nowrap">
						<div class="square_ico col col-verti-center">
							<i class="material-icons">add_shopping_cart</i>
						</div>
						<div class="col nowrap square_name col-verti-center">
							<span class="square_count"><?= $totalP; ?></span>
							<p class="square_subject">Template disponibles</p>
						</div>
					</div>
					<footer class="square_footer row row-hori-between row-verti-center" data-link="?module=user&action=template">
						<p>Voir les détails</p>
						<i class="material-icons">arrow_forward</i>
					</footer>
				</div>
				<div class="sm_square col nowrap">
					<div class="square_body row row-hori-between nowrap">
						<div class="square_ico col col-verti-center">
							<i class="material-icons">stars</i>
						</div>
						<div class="col nowrap square_name col-verti-center">
							<?php if (isset($_SESSION['subscriber'])): ?>
								<span class="square_count">1</span>
								<p class="square_subject"><?= $_SESSION['subscription']['name']; ?></p>
							<?php else: ?>
								<span class="square_count">0</span>
								<p class="square_subject">Aucun abonnement</p>
							<?php endif ?>
						
						</div>
					</div>
					<footer class="square_footer row row-hori-between row-verti-center" data-popup="stoppedSubscription">
						<p>Voir les détails</p>
						<i class="material-icons">arrow_forward</i>
					</footer>
				</div>
				<div class="sm_square col nowrap">
					<div class="square_body row row-hori-between nowrap">
						<div class="square_ico col col-verti-center">
							<i class="material-icons">email</i>
						</div>
						<div class="col nowrap square_name col-verti-center">
							<span class="square_count"><?= $Eperso ?></span>
							<p class="square_subject">Emails</p>
						</div>
					</div>
					<footer class="square_footer row row-hori-between row-verti-center" data-link="?module=user&action=emails">
						<p>Voir les détails</p>
						<i class="material-icons">arrow_forward</i>
					</footer>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body">
			<div class="row row-verti-center nowrap">
				<?php foreach ($emails as $key => $email) {
					$timestamp = new DateTime($email['timestamp']);
					$emailDate = $timestamp->format('d-m-Y');

					$folder = ''.$email['id_mail'].'_'.$emailDate.'/';
					$src = $chemin.'emails/'.$folder;
				?>
					<a data-turbolinks="false" style="background: url('<?= $src; ?>thumbs.png');" href="?module=user&action=email_builder&id=<?= $email['id_mail']; ?>" class="email_block" data-email="<?= $email['id_mail']; ?>">
					</a>
				<?php } ?>
				<a href="?module=user&action=emails" class="email_block col col-hori-center col-verti-center nowrap">
					<p>Voir tous mes emails</p>
				</a>
			</div>
		</div>
	</div>
</div>
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>