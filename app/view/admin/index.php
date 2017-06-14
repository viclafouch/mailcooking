<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="full-width container-dashboard col nowrap">
	<div class="pannel pannel-heading">
		<div class="title-dashboard full-width">
			<h1>Tableau de bord</h1>
		</div>
		<div class="date-dashboard full-width">
			<p>Periode: 25 octobre 2015 - 10 novembre 2015</p>
		</div>
	</div>
	<div class="pannel-body">
		<div class="row row-hori-center row-verti-center nowrap full-width">
			<div class="block_number">
				<div class="ico"></div>
				<div class="descr">
					<p>15</p>
					<p>en attente</p>
				</div>
			</div>
			<div class="block_number"></div>
			<div class="block_number"></div>
			<div class="block_number"></div>
		</div>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>