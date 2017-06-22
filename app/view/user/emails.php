<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="emails">
	<div class="nwrap">
		<h1>Vos emails</h1>
	</div>
	<div class="block_rows">
		<div class="column_title_block">
			<div class="title">
				<h2>Mes emails</h2>
				<a href="?module=user&action=archives" class="link_archive">Archives</a>
			</div>
			<div class="row_list_email active">
				<span class="arrow"><i class="arrow_slider arrow_left fa fa-arrow-circle-left" aria-hidden="true"></i></span>
				<div class="list">
					<div class="overflow sortable">
						<?php foreach ($emails as $data): ?>
							<?php if ($data["cat_id"] == NULL): ?>
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
</div>
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>