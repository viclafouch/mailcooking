<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_emails">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-hori-between row-verti-center">
				<div>
					<h1>Mes emails</h1>
				</div>
				<div class="row row-verti-center nowrap">
					<button class="button_default button_primary">Créer un email</button>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body" data-list-emails data-allow="0">
			<div class="col nowrap">
				<div class="pannel_title">
					<h2>Tous mes emails</h2>
				</div>
				<div class="pannel_body">
					<ul class="row row-verti-center nowrap emails_list">
						<?php foreach ($emails as $data): ?>
						<li class="email">
							<div data-toolbox class="row nowrap row-verti-center row-hori-center toolbox_email"></div>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
		</div>
		<?php foreach ($cat_user as $key => $cat): ?>
		<div class="pannel pannel_body" data-list-emails data-section="5" data-allow="1">
			<div class="col nowrap">
				<div class="pannel_title row row-verti-center">
					<p>
						<span spellcheck="false" onpaste="return false" class="title_row">Catégorie 1</span>
						&nbsp;
					</p>
				</div>
				<div class="pannel_body">
					<ul class="row row-verti-center nowrap emails_list">
						<li class="email">
							<div data-toolbox class="row nowrap row-verti-center row-hori-center toolbox_email"></div>
						</li>
						<li class="email">
							<div data-toolbox class="row nowrap row-verti-center row-hori-center toolbox_email"></div>
						</li>
						<li class="email">
							<div data-toolbox class="row nowrap row-verti-center row-hori-center toolbox_email"></div>
						</li>
						<li class="email">
							<div data-toolbox class="row nowrap row-verti-center row-hori-center toolbox_email"></div>
						</li>
						<li class="email">
							<div data-toolbox class="row nowrap row-verti-center row-hori-center toolbox_email"></div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<?php endforeach ?>
		<div class="pannel pannel_body" id="pannelAddSection">
			<div class="col nowrap">
				<div class="col col-verti-center col-hori-center nowrap add_section">
					<div class="flipper">
						<div id="newCatFlipper" class="flipper_front row row-hori-center row-verti-center">
							<p>Ajouter une section</p>
						</div>
						<div class="flipper_back row row-hori-center row-verti-center">
							<span id="closedFlipper"><i class="material-icons">close</i></span>
							<form method="post" action="" class="col col-verti-center">
								<input type="text" spellcheck="false" autocomplete="off" id="inputCatFlipper" placeholder="Nom de la section" />
								<button type="submit" id="saveCatFlipper" class="button_default">Ajouter</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- <div class="emails">
	<?php foreach ($cat_user as $key => $cat) { ?>
	<div class="block_rows cat" id="<?= $cat["cat_id"]; ?>">
		<div class="column_title_block">
			<div class="title">
				<div class="modif-cat-form">
					<input class="input" required type="text" name="cat_name" value="<?= $cat["cat_name"]; ?>">
					<h2 class="h2 active"><?= $cat["cat_name"]; ?></h2>
					<div class="tools_action_title_box">
						<span class="tools_action_title_btn pencil"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
						<span class="tools_action_title_btn trash"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
					</div>
				</div>
				<span class="accordeon"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
			</div>
			<div class="row_list_email">
				<span class="arrow"><i class="arrow_slider arrow_left fa fa-arrow-circle-left" aria-hidden="true"></i></span>
				<div class="list">
					<div class="overflow sortable">
						<?php foreach ($emails as $data): ?>
							<?php if ($data["cat_id"] == $cat["cat_id"]): ?>
								<div class="block email_block notarchive" id="<?php echo $data["id_mail"] ?>">
									<div class="overlay"></div>
									<img src="http://placehold.it/175x175" alt="" title="">
									<div class="tools_block">

									</div>
									<p class="title_mail"><?php echo $data["email_name"] ?></p>
								</div>	
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
				<span class="arrow"><i class="arrow_slider arrow_right fa fa-arrow-circle-right" aria-hidden="true"></i></span>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="add_section block_rows">
		<div class="flipper">
			<div class="front">
				<span class="span_add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter une section</span>
			</div>
			<div class="back">
				<div>
					<form method="post" id="new_cat" class="section_form">
						<input type="text" id="categorie_name" placeholder="Nom de la catégorie" />
						<input type="submit" value="OK" />
					</form>
					<span class="cancel_flip"><i class="fa fa-times" aria-hidden="true"></i></span>
				</div>
			</div>
		</div>
	</div>
</div> -->
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>