<?php

	/**
	 *
	 * Fichier d'affiche et de modifications des commandes
	 * Valeur des commandes : 
	 * 
	 * - 0 : En attente de validation
	 * - 1 : Prise en charge
	 * - 2 : Tester le template
	 * - 3 : Terminé
	 *
	 */


	/**
	 *
	 * Chaque modification de commande doit s'effectuer par un POST
	 *
	 */
	
	if (!empty($_POST)) {

		/**
		 *
		 * Valeur en cours : 1
		 * Valeur désirée : 2
		 * Fonction : Fonction : Sauvegarde de la thumbnail du template complet
		 *
		 */
		
		if (isset($_POST['thumbnail'])) {
			$chemin = $_POST['chemin'];
			$name = 'thumbnail';

			$savefile = @file_put_contents(	
				$chemin.$name.'.png',  
				base64_decode(explode(",", $_POST["thumbnail"])[1])
			);
		}

		/**
		 *
		 * Valeur en cours : 1
		 * Valeur désirée : 2
		 * Fonction : Sauvegarde de chacune des thumbnails du template
		 *
		 */
		
		elseif (isset($_POST['thumb'])) {
			$chemin = $_POST['chemin'];
			$name = $_POST['nameThumb'];

			$savefile = @file_put_contents(	
				$chemin.$name.'.png',  
				base64_decode(explode(",", $_POST["thumb"])[1])
			);
		}

		/**
		 *
		 * Valeur en cours : 1
		 * Valeur désirée : 2
		 * Fonction : Passage de la valeur a 2
		 * CC : Création du template en BDD
		 * CCP : Affichage en retour la popup de la valeur 2
		 *
		 */
		
		elseif (isset($_POST['addToBdd'])) {

			include_once('app/model/user/template/valide_order.php');

			$options = array( 	"wherecolumn"	=>	"id_commande",
								"wherevalue"	=>	$_POST['addToBdd']);
	
			$commande = selecttable("template_commande", $options);


			$orderID = $_POST['addToBdd'];
		    $dom = $_POST["DOM"];
		    $title = $commande[0]['nom_commande'];
		    $user = $_POST['userId'];
		    $medias = $_POST["mco_template_mobile"];
		   
		   	$newTemplate = addTemplateMail($dom, $medias, $title, $user, $orderID);

		   	include_once('app/model/admin/update_commande.php');

			$update = update_commande($orderID, 2);

			$options = array( 	"wherecolumn"	=>	"user_id",
								"wherevalue"	=>	$_POST['userId']);
	
			$user = selecttable("users", $options);
			
			?>

			<header>
				<h1>Commande N°<?= $commande[0]["id_commande"]; ?></h1>
			</header>
			<form method="post" action="">
				<div class="content_block popup-blocks">
					<div>
						<div class="field">
							<div class="oneside aside">
								<label>Statut :</label>
							</div>
							<div class="overside aside">
								<p>
									<span class="statut statut2">En attente de test</span>
								</p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label>Auteur :</label>
							</div>
							<div class="overside aside">
								<p><?= $user[0]["first_name"]; ?>&nbsp;<?= $user[0]["last_name"]; ?></p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label>Commentaires :</label>
							</div>
							<div class="overside aside">
								<p><?= $commande[0]["commentaire_commande"]; ?></p>
							</div>
						</div>
					</div>
				</div>
				<footer class="col col-hori-center col-verti-center nowrap" id="<?= $commande[0]['id_commande']; ?>">
					<button id="testOrder" class="button_default button_secondary">Tester le template</button>
					<p><a href="#" data-close-popup id="cancelUpload" title="">Annuler la mise en ligne</a></p>
				</footer>
			</form>
		<?php }

		/**
		 *
		 * Valeur en cours : 2
		 * Valeur désirée : 3
		 * Fonction : Création d'un email pour le test de celui-ci
		 * CCP : Retourne l'id du builder pour la redirection
		 *
		 */
		
		elseif (isset($_POST['testEmail'])) {

			$options = array( 	"wherecolumn"	=>	"id_template_commande",
								"wherevalue"	=>	$_POST['testEmail']);
	
			$commande = selecttable("template_mail", $options);

			include_once('app/model/user/email/insert_email.php');

			$id_mail = new_email($commande[0]['id_template'], $_SESSION["user"]["user_id"], $commande[0]['DOM']);

			if ($id_mail) {

				$options = array( 	
					"orderby"	=>	"id_mail",
					"order"	=>	'DESC',
					"limit" => 1);

				$email = selecttable("mail_editor", $options);

				$timestamp = new DateTime($email[0]['timestamp']);
				$email_date = $timestamp->format('d-m-Y');
				
				$new_folder = ''.$id_mail.'_'.$email_date.'';

				@mkdir($chemin.'emails/'.$new_folder."", 0777, true);

			}

			echo $id_mail; 
		}

		/**
		 *
		 * Valeur en cours : 2
		 * Valeur désirée : 1
		 * Fonction : Suppression du template et des emails associés
		 * CCP : Retourne la page de commandes
		 *
		 */
		
		elseif (isset($_POST['cancelUpload'])) {
			$orderID = $_POST['cancelUpload'];
			include_once('app/model/user/template/valide_order.php');
	
			$commande = get_infos(intval($orderID));

			include_once('app/model/admin/update_commande.php');

			$update = update_commande($orderID, 1);

			$id_user = $commande[0]["id_user"];
			$societe_user = mb_strtolower(substr($commande[0]["societe"], 0, 3));
			$chemin = "client/".$id_user."_".$societe_user."/";

			$template = $commande[0]["id_commande"].'_'.substr(str_replace(' ', '_', $commande[0]["nom_commande"]),0,15);

			$path = $chemin.'templates/'.$template;

			if (file_exists($path.'/images')) {
				removeFiles(glob($path.'/images/*'));
				rmdir($path.'/images');
			}
			if (file_exists($path.'/thumbnails')) {
				removeFiles(glob($path.'/thumbnails/*'));
				rmdir($path.'/thumbnails');
			}
			if (file_exists($path)) {
				removeFiles(glob($path));
				rmdir($path);
			}

			$template = selecttable('template_mail', 
				array(	'wherecolumn' 	=> 	'id_template_commande',
						'wherevalue'	=>	$commande[0]["id_commande"]
			));

			$email = selecttable('mail_editor', 
				array(	'wherecolumn' 	=> 	'template_id',
						'wherevalue'	=>	$template[0]["id_template"]
			));

			include_once('app/model/user/email/delete_email.php');

			foreach ($email as $key => $value) {
				$path = $chemin.'emails/';
				$timestamp = new DateTime($value['timestamp']);
				$email_date = $timestamp->format('d-m-Y');
				
				$folder = ''.$value['id_mail'].'_'.$email_date.'';
				$path = $path.$folder;

				if (file_exists($path)) {
					removeFiles(glob($path.'/*'));
					rmdir($path);
				}
				delete_email($value['id_mail'], $_SESSION['user']['user_id']);
			}

			include_once('app/model/user/template/delete_template.php');

			delete_template($orderID);

			echo '?module=admin&action=commandes';
		}

		/**
		 *
		 * Valeur en cours : 2
		 * Valeur désirée : 3
		 * Fonction : Valide le template en valeur 3 et supprime les emails associés
		 * CCP : Retourne la page de commandes
		 *
		 */
		
		elseif (isset($_POST['valideTemplate'])) {

			$orderID = $_POST['valideTemplate'];
			
			include_once('app/model/user/template/valide_order.php');
	
			$commande = get_infos(intval($orderID));

			include_once('app/model/admin/update_commande.php');

			$update_order = update_commande($orderID, 3);

			include_once('app/model/user/template/update_template.php');

			$update_template = update_template($orderID, 1);

			$template = selecttable('template_mail', 
				array(	'wherecolumn' 	=> 	'id_template_commande',
						'wherevalue'	=>	$commande[0]["id_commande"]
			));

			$email = selecttable('mail_editor', 
				array(	'wherecolumn' 	=> 	'template_id',
						'wherevalue'	=>	$template[0]["id_template"]
			));

			include_once('app/model/user/email/delete_email.php');

			$id_user = $commande[0]["id_user"];
			$societe_user = mb_strtolower(substr($commande[0]["societe"], 0, 3));
			$chemin = "client/".$id_user."_".$societe_user."/";

			foreach ($email as $key => $value) {
				$path = $chemin.'emails/';
				$timestamp = new DateTime($value['timestamp']);
				$email_date = $timestamp->format('d-m-Y');
				
				$folder = ''.$value['id_mail'].'_'.$email_date.'';
				$path = $path.$folder;

				if (file_exists($path)) {
					removeFiles(glob($path.'/*'));
					rmdir($path);
				}
				delete_email($value['id_mail'], $_SESSION['user']['user_id']);
			}
			echo '?module=admin&action=commandes';		
		}
		
		/**
		 *
		 * Valeur en cours : 0
		 * Valeur désirée : 1
		 * Fonction : Passe la commande à valeur 1
		 *
		 */
		
		elseif (isset($_POST['order'])) {
			include_once('app/model/admin/update_commande.php');

			$update = update_commande($_POST["order"], 1);
		}

		/**
		 *
		 * Valeur en cours : 1
		 * Valeur désirée : 2
		 * Fonction : Récupère l'archive image et extraction de celle-ci
		 * CCP : Retourne la bonne source pour les images
		 *
		 */
		
		elseif (isset($_FILES)) {
			$data['file'] = $_FILES;
		    $data['text'] = $_POST;

		    include_once('app/model/user/template/valide_order.php');
	
			$commande = get_infos(intval($_POST["id"]));
			
			$id_user = $commande[0]["id_user"];
			$societe_user = mb_strtolower(substr($commande[0]["societe"], 0, 3));
			$chemin = "client/".$id_user."_".$societe_user."/";

			$new_folder = $commande[0]["id_commande"].'_'.substr(str_replace(' ', '_', $commande[0]["nom_commande"]),0,15);

			@mkdir($chemin.'templates/'.$new_folder."", 0777, true);

			$chemin = $chemin.'templates/'.$new_folder.'/';

			@mkdir($chemin.'images');
			@mkdir($chemin.'thumbnails');

			$NameImageFolder = utf8_encode(str_replace(' ', '_', $_FILES['file_image']['name']));

			move_uploaded_file($_FILES['file_image']['tmp_name'], $chemin.'images/'.$NameImageFolder);

			unzip_file($chemin.'images/'.$NameImageFolder, $chemin.'images');

			echo $chemin.'images/';
		}
	}

	/**
	 *
	 * Les popup s'affichent via un GET
	 *
	 */
	

	/**
	 *
	 * Valeur en cours : 1
	 * Valeur désirée : 2
	 * Formulaire de mise en ligne du template
	 *
	 */

	elseif (isset($_GET['id_commande'])) { ?>

		<header>
			<h1>Mise en ligne du template</h1>
		</header>
		<form method="post" id="formPreviewTemplate" action="?module=admin&action=commandes" enctype="multipart/form-data">
			<div class="content_block popup-blocks">
				<div class="field">
					<div class="oneside aside">
						<label for="DOM">Code :*</label>
					</div>
					<div class="overside aside">
						<p><input id="OrderID" type="hidden" name="id" value="<?= $_GET['id_commande']; ?>" />
							<textarea spellcheck="false" autocomplete="false" name="DOM" id="DOM" required="required"></textarea>
						</p>
					</div>
				</div>
				<div class="field">
					<div class="oneside aside">
						<label for="mco_template_mobile">Media Query :*</label>
					</div>
					<div class="overside aside">
						<p>
							<textarea spellcheck="false" autocomplete="false" name="mco_template_mobile" id="mco_template_mobile" required="required"></textarea>
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
			</div>
			<footer class="col col-hori-center col-verti-center nowrap" id="<?= $_GET['id_commande']; ?>">
				<button id="previewUploadTemplate" class="button_default button_secondary">Prévisualiser</button>
			</footer>
		</form>

	<?php } 

	/**
	 *
	 * Valeur en cours : 2
	 * Valeur désirée : 3
	 * Demande de test du template
	 *
	 */

	elseif (isset($_GET['testTemplate'])) { ?>

		<header>
			<h1>Mise en ligne du template</h1>
		</header>
		<div class="content_block popup-blocks row row-verti-center row-hori-center" style="height: 110px;">
			<button class="button_default" data-try="true">
				<span class="buttoneffect"></span>
				<span class="text-cta" data-order="<?= $_GET['testTemplate'] ?>">Tester le template</span>
			</button>
		</div>
		<footer class="row row-hori-center nowrap test_template">
			<a href="#" id="cancelUpload" title="">Annuler la mise en ligne</a>
			<a href="#" id="testLaster" title="">Essayer plus tard</a>
		</footer>
	
	<?php }

	/**
	 *
	 * Valeur en cours : X
	 * Valeur désirée : X
	 * Popup de base
	 *
	 */
	
	elseif (isset($_GET['id'])) {

		include_once('app/model/admin/lire_commande.php');

		$commande = lire_commande($_GET["id"]);

		if ($commande) { 
			$keep_status = $commande[0]["status"];
			if ($commande[0]["status"] == 0) {
				$commande[0]["status"] = "En attente de validation";
			} elseif ($commande[0]["status"] == 1) {
				$commande[0]["status"] = "Prise en charge";
			} elseif ($commande[0]["status"] == 2) {
				$commande[0]["status"] = "En attente de test";
			} elseif ($commande[0]["status"] == 3) {
				$commande[0]["status"] = "Terminé";
			} ?>
			<header>
				<h1>Commande N°<?= $commande[0]["id_commande"]; ?></h1>
			</header>
			<form method="post" action="">
				<div class="content_block popup-blocks">
					<div>
						<div class="field">
							<div class="oneside aside">
								<label>Statut :</label>
							</div>
							<div class="overside aside">
								<p>
									<span class="statut statut<?= $keep_status ?>"><?= $commande[0]["status"]; ?></span>
								</p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label>Auteur :</label>
							</div>
							<div class="overside aside">
								<p><?= $commande[0]["first_name"]; ?>&nbsp;<?= $commande[0]["last_name"]; ?></p>
							</div>
						</div>
						<div class="field">
							<div class="oneside aside">
								<label>Commentaires :</label>
							</div>
							<div class="overside aside">
								<p><?= $commande[0]["commentaire_commande"]; ?></p>
							</div>
						</div>
					</div>
				</div>
				<footer class="col col-hori-center col-verti-center nowrap" id="<?= $commande[0]['id_commande']; ?>">
					<?php if ($keep_status == 0) { ?>
					<button id="valideOrder" class="button_default button_secondary">Valider la prise en charge</button>
					<?php } elseif ($keep_status == 1) { ?>
					<p>Commande prise en charge depuis le 01/05/2016</p>
					<button id="finishOrder" class="button_default button_secondary">Prise en charge terminée</button>
					<?php } elseif ($keep_status == 2) { ?>
					<button id="testOrder" class="button_default button_secondary">Tester le template</button>
					<p><a href="#" data-close-popup id="cancelUpload" title="">Annuler la mise en ligne</a></p>
					<?php } elseif ($keep_status == 3) { ?>
					<p>Commande terminée le 01/05/2016</p>
					<?php } ?>
				</footer>
			</form>
		<?php }
	}

	/**
	 *
	 * Affichage de la vue
	 * Envoie des données pour la lectures des commandes
	 *
	 */

	else {

		$nb_commandes = counttable("template_commande");

		include_once('app/model/admin/lire_commandes.php');

		$users = lire_commandes();

		metadatas('Les commandes', 'Description', 'none');

		include_once('app/view/admin/commandes.php');
	}