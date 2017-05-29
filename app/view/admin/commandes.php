<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="commandes">
	<div class="nwrap">
		<h1>Les commandes</h1>
	</div>
	<div class="datas_commandes container_to_table">
		<table>
			<caption>Il y a <?= $nb_commandes; ?> commandes</caption>
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
			<?php foreach ($users as $key => $data) { 
				$keep_status = $data["status"];
				if ($data["status"] == 0) {
					$data["status"] = "En attente de validation";
				} elseif ($data["status"] == 1) {
					$data["status"] = "Prise en charge";
				} elseif ($data["status"] == 2) {
					$data["status"] = "Terminé";
			}?>
				<tr class="row_data_commande" id="<?= $data["id_commande"]; ?>">
					<td><?= $data["id_commande"]; ?></td>
					<td><?= $data["first_name"]; ?> <?= $data["last_name"]; ?></td>
					<td><?= $data["nom_commande"]; ?></td>
					<td><?= htmlspecialchars(substr($data["commentaire_commande"],0,10)); ?>...</td>
					<td><?= $data["date_creat"]; ?></td>
					<td class="td_<?= $data["id_commande"]; ?>"><span class="label statut<?= $keep_status ?>"><?= $data["status"]; ?></span></td>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="popup-overlay"></div>
	<div class="popup-container commande">
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>