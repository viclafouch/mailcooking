<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="emails">
	<div class="nwrap">
		<h1>Archives</h1>
	</div>
	<div class="block_rows">
		<div class="column_title_block">
			<div class="title">
				<div>
					<h2>Toutes vos archives <span id="nb_archives">(<?php echo $nb_archives ?>)</span></h2>
					<div class="action_archive">
						<span class="btn_act_arch" id="select_all_archives">Tout sélectionner</span>
						<span class="btn_act_arch disabled" id="deselect_all_archives">Tout déselectionner</span>
					</div>
				</div>
				<div class="action_archive">
					<span class="btn_act_arch disabled btn_action" id="restore_email"><i class="material-icons">cached</i> <span> Restaurer</span></span>
					<span class="btn_act_arch disabled btn_action" id="delete_email"><i class="material-icons">delete</i><span> Supprimer</span></span>
				</div>
			</div>
			<div class="row_list_email archives">
				<?php foreach ($emails as $key => $data): ?>
					<div class="block email_block arch" id="<?php echo $data["id_mail"] ?>">
						<!-- <div class="overlay"></div -->
						<img src="http://image.prntscr.com/image/37540bbac1cf40bf89e40f293f2394e7.jpeg" alt="" title="">
						<div class="check_div">
							<span class="checkbox nocheck"></span>
						</div>
						<p class="title_mail"><?php echo $data["email_name"] ?></p>
					</div>	
				<?php endforeach ?>	
			</div>
		</div>
	</div>
</div>
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>