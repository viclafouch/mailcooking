<?php 

	if (!isset($_POST["nom_commande"])) {

		if (isset($_GET["id"])) {

			// Appel du modèle pour la preview du template
			include_once("app/model/user/template/preview_template.php");

			if ($_GET['allow'] == 0) {
				$temp = preview_template($_GET["id"], 'all');
			} else {
				$temp = preview_template($_GET['id'], $_SESSION['user']['user_id']);
			}

			echo $temp[0]["DOM"];

		}
		elseif (isset($_POST['templates'])) {
			// Appel du modèle pour l'affichage des templates
			include_once("app/model/user/template/read_templates.php");

			if ($_POST['templates'] == 1 && $_POST['orderby'] == 1) {
				$template = read_templates($_SESSION["user"]["user_id"], 'DESC');
			}
			elseif ($_POST['templates'] == 0 && $_POST['orderby'] == 1) {
				$template = read_templates('all', 'DESC');
			}
			elseif ($_POST['templates'] == 1 && $_POST['orderby'] == 0) {
				$template = read_templates($_SESSION["user"]["user_id"], 'ASC');
			}
			elseif ($_POST['templates'] == 0 && $_POST['orderby'] == 0) {
				$template = read_templates("all", 'ASC');
			}
			
			foreach ($template as $key => $temp) { ?>
				<?php 
					// Compter le nombre de mails utilisés par le template
					$options = array ("wherecolumn" => "template_id", 
										"wherevalue" => $temp['id_template']);
					$countMailsEditor = counttable("mail_editor", $options);
				?>
				<li class="row nowrap row-hori-between li_template" data-allow="<?php if ($temp['id_allow'] == 'all') { ?>0<?php } else { ?>1<?php } ?>" data-template="<?= $temp['id_template']; ?>">
					<div class="row nowrap">
						<div class="col nowrap col_template_thumbs">
							<img src="http://via.placeholder.com/120x170" alt="">
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
								<p><strong>Commande terminée</strong> le 24 Mai 2016</p>
								<p>Utilisé actuellement dans <strong><?= $countMailsEditor; ?></strong> email<?php if ($countMailsEditor > 1) { ?>s
								<?php } ?></p>
							</div>
						</div>
					</div>
					<div class="col nowrap">
						<div class="row wrap row-verti-center row-hori-between row_actions_template">
							<button class="button_default button_secondary">Créer un email</button>
							<button data-action-template class="button_default button_secondary"><i class="material-icons data-action-template">expand_more</i></button>
						</div>
						<div class="popup_action_template">
							<ul class="col nowrap">
								<li data-preview>Prévisualiser</li>
								<?php if ($temp['id_allow'] != 'all'): ?>
								<li>Demander une modification</li>
								<li>Supprimer</li>	
								<?php endif ?>
							</ul>
						</div>
					</div>
				</li>
			<?php }
		}
		elseif (isset($_POST['template_title'])) {
			include_once('app/model/user/template/update_title_template.php');

			update_title_template($_POST['idTemplate'], $_POST['template_title']);
		}
		else {
			protec();

			// Appel du modèle pour l'affichage des templates
			include_once("app/model/user/template/read_templates.php");

			// Compter le nombre de templates perso
			$options = array ("wherecolumn" => "id_allow", 
								"wherevalue" => $_SESSION['user']['user_id']);
			$perso = counttable("template_mail", $options);

			if ($perso >= 1) {
				// Affichage des templates persos
				$public = false;
				$template = read_templates($_SESSION["user"]["user_id"], 'DESC');
			}
			else {
				// Affichage des templates publics
				$public = true;
				$template = read_templates('all', 'DESC');
			}

			metadatas('Mes templates', 'Description', 'none');

			// Appel de la view
			include_once("app/view/user/template.php");
		}		
	}
	else {

		// Appel du modèle pour l'insertion de la commande
		include_once("app/model/user/template/creat_order.php");

		// Défintion du statut par défault
		$default_statut = 0;

		// Insertion de la commande
		$new_order = new_order($_POST, $_SESSION["user"]["user_id"], $default_statut);

		if (!$new_order) { location('user', 'template', 'notif=nok'); } 
		else {

			$new_folder = $new_order.'_'.substr(str_replace(' ', '_', $_POST["nom_commande"]),0,15);
			@mkdir($chemin.'commandes/'.$new_folder."", 0777, true);

			$folder = $chemin.'commandes/'.$new_folder.'/';

			// Upload du fichier dans le dossier 
			move_uploaded_file($_FILES['file_commande']['tmp_name'], $folder.$_FILES['file_commande']['name']);

			location('user', 'template', "notif=ok"); 
		}
	}

	