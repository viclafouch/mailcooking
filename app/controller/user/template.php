<?php 

	/**
	 *
	 * Fichier d'affichage et de templates
	 *
	 */

	/**
	 *
	 * Fonction de sécurité
	 * Vérification d'une session
	 *
	 */

	protec();

	/**
	 *
	 * Chaque modification de template doit s'effectuer par un POST
	 *
	 */



		/**
		 *
		 * Fonction d'aperçu d'un template
		 * CCP : Retourne le DOM du template
		 *
		 */

	if (isset($_GET["id"])) {

		include_once("app/model/user/template/preview_template.php");

		if ($_GET['allow'] == 0) { $temp = preview_template($_GET["id"], 'all'); } 
		else { $temp = preview_template($_GET['id'], $sessionID); }
		
		echo $temp[0]["DOM"];
		return;

	} 

	if (isset($_GET['stripeOrder'])) {
		$data = [
		    'key' => $stripeKeys['publishable_key'],
		    'image' => $stripeImg,
		    'locale' => 'auto',
		    'name' => $appName,
		    'zipCode' => false,
		    'currency' => 'EUR',
		    'description' => '1 commande de template',
		    'amount' => $priceTemplate * 100,
		];
		echo json_encode($data);
		return;
	}

	/**
	 *
	 * Fonction d'appel des templates lors de la modification des filtres
	 * CCP : Retourne X lignes de template
	 *
	 */

	if (!empty($_POST)) {

		if (isset($_POST['templates'])) {
	
			include_once("app/model/user/template/read_templates.php");

			if (boolval($_POST['templates'])) { $whose = $sessionID; }
			else { $whose = 'all'; }

			if (boolval($_POST['orderby'])) { $orderBy = 'DESC'; }
			else { $orderBy = 'ASC'; }

			$template = read_templates($whose, $orderBy);
		
			foreach ($template as $key => $temp) { ?>
				<?php

					include_once('app/model/user/template/valide_order.php');
					
					$options = array ("wherecolumn" => "template_id", 
										"wherevalue" => $temp['id_template']);
					$countMailsEditor = counttable("mail_editor", $options);

					if ($whose == 'all') {
						$folder = 'template_public_'.$temp['id_template'];
						$path = './template_all/'.$folder;
					} else {
						$commande = get_infos(intval($temp["id_template_commande"]));
						$folder = $commande[0]["id_commande"].'_'.substr(str_replace(' ', '_', $commande[0]["nom_commande"]),0,15);
						$path = $chemin.'templates/'.$folder;
					}
				?>

				<li class="row nowrap row-hori-between li_template" data-allow="<?php if ($temp['id_allow'] == 'all') { ?>0<?php } else { ?>1<?php } ?>" data-template="<?= $temp['id_template']; ?>">
					<div class="row nowrap">
						<div style="background: url('<?= $path.'/thumbnails/thumbnail.png'; ?>');" data-popup-preview class="col nowrap col_template_thumbs">
						</div>
						<div class="col nowrap col_template_descr">
							<p class="title_row"><span class="title_template" contenteditable="false" onpaste="return false;" spellcheck="false"><?= $temp['title_template']?></span>&nbsp;</p>
							<div class="info_template">
								<p>Template <?php if ($temp['id_allow'] == 'all') { ?>
									public <i class="material-icons">public</i>
								<?php } else { ?>
									perso <i class="material-icons">perm_identity</i>
								<?php } ?>
								</p>
								<?php if ($temp['id_allow'] != 'all') { 
									$timestamp = new DateTime($temp['upload_template_date']);
									$templateDate = $timestamp->format('d/m/Y');
								?>
										<p><strong>Commande terminée</strong> le <?= $templateDate ?></p>
								<?php } ?>
								<p>Utilisé actuellement dans <strong><?= $countMailsEditor; ?></strong> email<?php if ($countMailsEditor > 1) { ?>s<?php } ?></p>
							</div>
						</div>
					</div>
					<div class="col nowrap">
						<div class="row wrap row-verti-center row-hori-between row_actions_template">
							<button data-creat-email class="button_default button_secondary">Créer un email</button>
							<button data-action-template class="button_default button_secondary"><i class="material-icons data-action-template">expand_more</i></button>
						</div>
						<div class="popup_action_template">
							<ul class="col nowrap">
								<li data-popup-preview>Prévisualiser</li>
							</ul>
						</div>
					</div>
				</li>
			<?php  }
			return;
		}

		/**
		 *
		 * Fonction de modification de titre de template perso
		 *
		 */

		elseif (isset($_POST['template_title'])) {
			include_once('app/model/user/template/update_title_template.php');

			update_title_template($_POST['idTemplate'], $_POST['template_title']);

			return;
		}

		/**
		 *
		 * Fonction de création d'un email
		 * CCP : Retourne l'id du mail créé
		 *
		 */

		elseif (isset($_POST['template_id'])) {
			
			$options = array( 	"wherecolumn"	=>	"id_template",
								"wherevalue"	=>	$_POST['template_id']);

			$template = selecttable("template_mail", $options);

			include_once('app/model/user/email/insert_email.php');

			$id_mail = new_email($template[0]['id_template'], $sessionID, $template[0]['DOM']);

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

				$emailFolder = $chemin.'emails/'.$new_folder;

				if ($template[0]['id_allow'] == $sessionID) {

					$options = array( 	"wherecolumn"	=>	"id_commande",
								"wherevalue"	=>	$template[0]['id_template_commande']);

					$order = selecttable("template_commande", $options);

					$folder = $order[0]["id_commande"].'_'.substr(str_replace(' ', '_', $order[0]["nom_commande"]),0,15);

					$chemin = $chemin.'templates/'.$folder.'/';
					$src = $chemin.'/images';
					$dest =  $emailFolder;
					$files = glob($src.'/*.*');

					foreach($files as $file){
						$file_to_go = str_replace($src,$dest,$file);
						copy($file, $file_to_go);
					}
				}

			}

			echo $id_mail; 
			return;
		}

		/**
		 *
		 * Fonction de création d'une commande
		 *
		 */

		if (isset($_POST["nom_commande"])) {
			function creatOrder($post, $paid, $path, $sessionID, $count = false) {
				include_once("app/model/user/template/creat_order.php");

				$default_statut = 0;

				$date = date('Y-m-d');
				$expiration = date('Y-m-d', strtotime('+1 year', strtotime($date)));

				$new_order = new_order($post, $sessionID, $default_statut, $paid, $date);

				if ($count) {
					$newTemplateCount = newTemplateCount($new_order, $sessionID, $expiration);
				}

				else {

					$new_folder = $new_order.'_'.substr(str_replace(' ', '_', $post["nom_commande"]),0,15);
					@mkdir($path.'commandes/'.$new_folder."", 0777, true);

					$folder = $path.'commandes/'.$new_folder.'/';

					move_uploaded_file($_FILES['file_commande']['tmp_name'], $folder.$_FILES['file_commande']['name']);

					location('user', 'template', "order=valide");
					exit(0);
				}
			}

			if (isset($_POST['stripeToken'])) {
				include_once('app/controller/user/checkout.php');
				if (!isset($err)) {
					creatOrder($_POST, 1, $chemin, $sessionID);
				} else {
					location('user', 'template', 'err='.$err);
				}
			} else {
				if (isset($subscriber)) {
					$options = array (
							"wherecolumn" => "user_id", 
							"wherevalue" => $sessionID
					);
					$countUserTemplate = counttable("template_counter", $options);

					if ($countUserTemplate + 1 > intval($_SESSION['subscription']['privateTemplate'])) { 
						location('user', 'template', 'order=max'); } 
					else { 
						creatOrder($_POST, 0, $chemin, $sessionID, true); 
					}
				} else {
					location('user', 'template', 'order=subscription');
				}
			}
			return;
		}
	}

	/**
	 *
	 * Affichage de la vue
	 *
	 */

	else {
		protec();

		include_once('app/model/user/template/valide_order.php');

		include_once("app/model/user/template/read_templates.php");

		$options = array ("wherecolumn" => "id_allow", 
							"wherevalue" => $sessionID);
		$perso = counttable("template_mail", $options);

		if ($perso >= 1) {
			$public = false;
			$template = read_templates($sessionID, 'DESC');
		}
		else {
			$public = true;
			$template = read_templates('all', 'DESC');
		}

		$options = array (
					"wherecolumn" => "user_id", 
					"wherevalue" => $sessionID
			);
		$countUserTemplate = counttable("template_counter", $options);

		metadatas('Mes templates', 'Description', 'none');

		include_once("app/view/user/template.php");
	}	