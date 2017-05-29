<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="users">
	<div class="nwrap">
		<h1>Les utilisateurs</h1>
	</div>
	<div class="data_users container_to_table">
		<table>
			<caption>Il y a <?= $nb_users; ?> utilisateurs</caption>
			<thead>
				<tr>
					<th>ID</th>
					<th>Email</th>
					<th>Prénom</th>
					<th>Nom</th>
					<th>Société</th>
					<th>Téléphone</th>
					<th>Civilité</th>
					<th>Statut</th>
					<th>Date de création</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $key => $data) { ?>
				<tr>
					<td><?= $data["user_id"]; ?></td>
					<td><?= $data["user_email"]; ?></td>
					<td><?= $data["first_name"]; ?></td>
					<td><?= $data["last_name"]; ?></td>
					<td><?= $data["societe"]; ?></td>
					<td><?= $data["nb_phone"]; ?></td>
					<td><?= $data["gender"]; ?></td>
					<td><?= $data["valide"]; ?></td>
					<td><?= $data["timestamp"]; ?></td>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>