<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_orders">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-verti-center row-hori-between">
				<div>
					<h1>Commandes</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body container_to_table">
			<table class="table_order">
				<thead>
					<tr>
						<th>ID</th>
						<th>Auteur</th>
						<th>Nom de la commande</th>
						<th>Commentaire</th>
						<th>Date de création</th>
						<th>Statut</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($users as $key => $order) { 
					$keep_status = $order["status"];
					if ($order["status"] == 0) {
						$order["status"] = "En attente de validation";
					} elseif ($order["status"] == 1) {
						$order["status"] = "Prise en charge";
					} elseif ($order["status"] == 2) {
						$order["status"] = "En attente de test";
					} elseif ($order["status"] == 3) {
						$order["status"] = "Terminé";
				} ?>
					<tr data-order="<?= $order["id_commande"]; ?>">
						<td><?= $order["id_commande"]; ?></td>
						<td><?= $order["first_name"]; ?> <?= $order["last_name"]; ?></td>
						<td><?= $order["nom_commande"]; ?></td>
						<td><?= htmlspecialchars(substr($order["commentaire_commande"],0,10)); ?>...</td>
						<td><?= $order["date_creat"]; ?></td>
						<td><span class="statut statut<?= $keep_status ?>"><?= $order["status"]; ?></span></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="popup_mc" id="orderPopup">
		<div class="popup_background"></div>
		<div class="popup_container"></div>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>