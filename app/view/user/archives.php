<?php 
	// Appel du layout header
	include("app/view/layout/user/header.php"); 
?>

<div class="container container_archives">
	<div class="block full_block">
		<div class="pannel pannel_heading">
			<div class="row nowrap row-hori-between row-verti-center">
				<div>
					<h1>Mes archives</h1>
				</div>
				<div class="row row-verti-center nowrap">
					<a href="?module=user&action=emails" title="" data-popup-order class="button_default button_primary button_href">Mes emails</a>
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block"> 
		<div class="pannel pannel_body">
			<div class="row row-verti-center row-hori-between nowrap line_btn_archives">
				<div class="row nowrap">
					<button data-select-archive="allselect" class="selection button_default button_secondary active">Tout sélectionner</button>
					<button data-select-archive="deselect" disabled="disabled" class="selection button_default button_secondary">Tout déselectionner</button>		
				</div>
				<div class="row nowrap">
					<button data-remove-archive="delete" disabled="disabled" class="action button_default button_secondary"><i class="material-icons">delete</i> Supprimer</button>
					<button data-remove-archive="restore" disabled="disabled" class="action button_default button_secondary"><i class="material-icons">cached</i> Restaurer</button>		
				</div>
			</div>
		</div>
	</div>
	<div class="block full_block">
		<div class="pannel pannel_body">
			<ul class="row wrap">
			<?php foreach ($archives as $key => $archive): ?>
				<?php 
					$timestamp = new DateTime($archive['timestamp']);
					$emailDate = $timestamp->format('d-m-Y');

					$folder = ''.$archive['id_mail'].'_'.$emailDate.'/';
					$src = $chemin.'emails/'.$folder;
				?>
				<li style="background: url('<?= $src; ?>thumbs.png');" data-archive="<?= $archive['id_mail']; ?>" class="archive">
					<span class="helper_select"></span>
				</li>
			<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>
<?php 
	// Appel du layout footer
	include("app/view/layout/user/footer.php"); 
?>