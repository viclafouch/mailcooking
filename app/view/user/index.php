<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_template">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-hori-between row-verti-center">
				<div>
					<h1>Tableau de bord</h1>
				</div>
				<div class="row row-verti-center nowrap">
					<button class="button_default button_primary">Créer un email</button>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body">
			<div class="row row-hori-center nowrap">
				<div class="sm_square col nowrap">
					<div class="square_body row row-hori-between nowrap">
						<div class="square_ico col col-verti-center">
							<i class="material-icons">add_shopping_cart</i>
						</div>
						<div class="col nowrap square_name col-verti-center">
							<span class="square_count">25</span>
							<p class="square_subject">Commandes en cours</p>
						</div>
					</div>
					<footer class="square_footer row row-hori-between row-verti-center">
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
							<span class="square_count">1</span>
							<p class="square_subject">Abonnement tip</p>
						</div>
					</div>
					<footer class="square_footer row row-hori-between row-verti-center">
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
							<span class="square_count">42</span>
							<p class="square_subject">Emails</p>
						</div>
					</div>
					<footer class="square_footer row row-hori-between row-verti-center">
						<p>Voir les détails</p>
						<i class="material-icons">arrow_forward</i>
					</footer>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>