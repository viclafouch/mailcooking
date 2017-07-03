<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_users">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-verti-center row-hori-between">
				<div>
					<h1>Utilisateurs</h1>
				</div>
<!-- 				<button type="submit" class="button_default button_primary">Mon abonnement</button>
 -->		</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body container_to_table">
			<table class="table_users">
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
					<?php foreach ($users as $key => $user) {
						$timestamp = new DateTime($user['timestamp']);
						$userDateCreat = $timestamp->format('d/m/Y');

					?>

					<tr>
						<td><?= $user["user_id"]; ?></td>
						<td><?= $user["user_email"]; ?></td>
						<td><?= $user["first_name"]; ?></td>
						<td><?= $user["last_name"]; ?></td>
						<td><?= $user["user_societe"]; ?></td>
						<td><?= $user["nb_phone"]; ?></td>
						<td><?= $user["gender"]; ?></td>
						<td><?= $user["valide"]; ?></td>
						<td><?= $userDateCreat; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>