				</section>
			</div>
		</main>
		<script src="lib/js/turbolinks/turbolinks.js"></script>
		<script src="lib/js/jquery/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="webroot/js/script.js"></script>
		<script src="lib/js/html2canvas/html2canvas.js" type="text/javascript"></script>
		<script src="lib/js/jquery-ui/jquery-ui.min.js"></script>

		<?php 
			if ($_GET['action'] == 'email_builder') { ?>

				<script src="lib/js/croppie/croppie-2.4.1.min.js"></script>
				<script src="lib/js/jquery-minicolors/jquery.minicolors.min.js"></script>
				<script src="lib/js/medium-editor/medium-editor.min.js" type="text/javascript"></script>
 				<script src="lib/js/undo-manager/undo-manager.js" type="text/javascript"></script>
				<script src="webroot/js/builder/edit_img.js" type="text/javascript"></script>
				<script src="webroot/js/builder/edit_text.js" type="text/javascript"></script>
				<script src="webroot/js/builder/control_sections.js" type="text/javascript"></script>
				<script src="webroot/js/builder/control_menus.js" type="text/javascript"></script>
				<script src="webroot/js/builder/actions_build.js" type="text/javascript"></script>
			<?php }
			if (isset($_GET["order"])) {
				if ($_GET["order"] == "valide") { ?>
					<script>
						insertAlert('Commande envoyée !', true);
					</script>
				<?php }
			}
			if (isset($_GET["err"])) { ?>
				<script>
					if (StripeErr.<?= $_GET["err"]; ?>) {
						insertAlert(StripeErr.<?= $_GET["err"]; ?>, false);
					}
				</script>
			<?php }
		?>
	</body>
</html>