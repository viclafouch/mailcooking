<?php 
	if (isset($_POST["id"])) {
	
		if (isset($_POST["DOM"])) {

			include_once('app/model/user/template/valide_order.php');
	
			$commande = get_infos($_POST["id"]);
			
			$id_user = $commande[0]["id_user"];
			$societe_user = mb_strtolower(substr($commande[0]["societe"], 0, 3));
			$chemin = "client/".$id_user."_".$societe_user."/";

			$new_folder = $commande[0]["id_commande"].'_'.substr(str_replace(' ', '_', $commande[0]["nom_commande"]),0,15);

			@mkdir($chemin.'templates/'.$new_folder."", 0777, true);

			$folder = $chemin.'templates/'.$new_folder.'/';

			@mkdir($folder.'images');
			@mkdir($folder.'thumbnails');

			echo "<p>dossiers créés</p>";

			// // Upload du fichier dans le dossier 
			$NameImageFolder = utf8_encode(str_replace(' ', '_', $_FILES['file_image']['name']));
			$NameThumbnailFolder = utf8_encode(str_replace(' ', '_', $_FILES['file_thumbnail']['name']));

			move_uploaded_file($_FILES['file_thumbnail']['tmp_name'], $folder.'thumbnails/'.$NameThumbnailFolder);
			move_uploaded_file($_FILES['file_image']['tmp_name'], $folder.'images/'.$NameImageFolder);

			echo "<p>fichiers déplacés<p>";

			unzip_file($folder.'images/'.$NameImageFolder, $folder.'images');
			unzip_file($folder.'thumbnails/'.$NameThumbnailFolder, $folder.'thumbnails');

			echo "<p>archives extraites</p>";

			$data = addTemplateMail($_POST["DOM"], $_POST["mco_template_mobile"], $id_user, $commande[0]["id_commande"]);

			var_dump($data);

			echo "<p>Redirection vers l'email builder avec demande de confirmation pour envoyer un email de notification au user en question.</p>";

		}
		else {
			sleep(3);
			include_once('app/model/admin/update_commande.php');

			$update = update_commande($_POST["id"], 1);

			if ($update) {
				echo "ok";
			} else {
				echo "nok";
			}
		}
	}
	else if (!isset($_GET["id"])) {

		// Finish order
		if (isset($_GET['id_commande'])) { ?>
		<header>
			<h1>Mise en ligne du template</h1>
		</header>
		<form method="post" action="?module=admin&action=commandes" enctype="multipart/form-data">
			<div class="content_block popup-blocks">
				<div>
					<div class="field">
						<div class="oneside aside">
							<label for="DOM">Code :*</label>
						</div>
						<div class="overside aside">
							<p><input type="hidden" name="id" value="<?= $_GET['id_commande']; ?>" />
								<textarea name="DOM" id="DOM" required="required"></textarea>
							</p>
						</div>
					</div>
					<div class="field">
						<div class="oneside aside">
							<label for="mco_template_mobile">Media Query :*</label>
						</div>
						<div class="overside aside">
							<p><input type="hidden" name="id" value="<?= $_GET['id_commande']; ?>" />
								<textarea name="mco_template_mobile" id="mco_template_mobile" required="required"></textarea>
							</p>
						</div>
					</div>
					<div class="field">
						<div class="oneside aside">
							<label for="file_image">Image :*</label>
						</div>
						<div class="overside aside">
							<p>
								<input type="file" accept="application/zip" name="file_image" id="file_image" required="required">
							</p>
						</div>
					</div>
					<div class="field">
						<div class="oneside aside">
							<label for="file_thumbnail">Thumbnail :*</label>
						</div>
						<div class="overside aside">
							<p>
								<input type="file" accept="application/zip" name="file_thumbnail" id="file_thumbnail" required="required">
							</p>
						</div>
					</div>
				</div>
			</div>
			<footer>
				<div>
					<button type="submit" id="<?= $_GET["id_commande"]; ?>" class="button_default">
						<span class="buttoneffect"></span>
						<span class="text-cta">Prévisualisation</span>
					</button>
				</div>
			</footer>
		</form>
		<?php } else {

			// Secu
			// protec();
			// just_admin();

			$nb_commandes = counttable("template_commande");

			include_once('app/model/admin/lire_commandes.php');

			$users = lire_commandes();

			metadatas('Les commandes', 'Description', 'none');

			include_once('app/view/admin/commandes.php');
		}
	}
	else {

		include_once('app/model/admin/lire_commande.php');

		$commande = lire_commande($_GET["id"]);

		if ($commande) { 
			$keep_status = $commande[0]["status"];
			if ($commande[0]["status"] == 0) {
				$commande[0]["status"] = "En attente de validation";
			} elseif ($commande[0]["status"] == 1) {
				$commande[0]["status"] = "Prise en charge";
			} elseif ($commande[0]["status"] == 2) {
				$commande[0]["status"] = "Terminé";
			} ?>
			<header>
				<h1>Commande N°<?= $commande[0]["id_commande"]; ?></h1>
			</header>
			<div class="content_block popup-blocks">
				<div>
					<div class="field">
						<div class="oneside aside">
							<p>Statut</p>
						</div>
						<div class="overside aside">
							<p id="statut_change">
								<span class="label statut<?= $keep_status ?>"><?= $commande[0]["status"]; ?></span>
							</p>
						</div>
					</div>
					<div class="field">
						<div class="oneside aside">
							<p>Auteur :</p>
						</div>
						<div class="overside aside">
							<p><?= $commande[0]["first_name"]; ?> <?= $commande[0]["last_name"]; ?></p>
						</div>
					</div>
					<div class="field">
						<div class="oneside aside">
							<p>Commentaire :</p>
						</div>
						<div class="overside aside">
							<p><?= $commande[0]["commentaire_commande"]; ?></p>
						</div>
					</div>
				</div>
			</div>
			<?php if ($keep_status == 0) { ?>
				<footer id="<?= $commande[0]["id_commande"]; ?>">
					<button class="valide button_default" id="valide_order">
						<span class="buttoneffect"></span>
						<span class="text-cta">Valider la prise en charge</span>
					</button>
				</footer>
			<?php } elseif ($keep_status == 1) { ?>
				<footer id="<?= $commande[0]["id_commande"]; ?>" class="confirmation endTakingCharge">
					<p>Commande prise en charge depuis le 01/05/2016</p>
					<button class="valide button_default" id="finish_order">
						<span class="buttoneffect"></span>
						<span class="text-cta">Prise en charge terminée</span>
					</button>
				</footer>
			<?php } elseif ($keep_status == 2) { ?>
				<footer id="<?= $commande[0]["id_commande"]; ?>">
					<p>Commande terminé le 01/05/2016</p>
				</footer>
			<?php } 
		}
	}