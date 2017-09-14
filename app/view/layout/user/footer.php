				</section>
			</div>
		</main>
		<script src="webroot/js/min/script.min.js" type="text/javascript"></script>

		<?php 
			if ($_GET['action'] == 'email_builder') { ?>
				<script src="webroot/js/builder.js" type="text/javascript"></script>
			<?php }
			if (isset($_GET["order"])) {
				if ($_GET["order"] == "valide") { ?>
					<script>
						insertAlert('Commande envoyée !', true);
					</script>
				<?php }
				if ($_GET["order"] == "max") { ?>
					<script>
						insertAlert('Vous avez atteint le nombre max de templates', false);
					</script>
				<?php }
				if ($_GET["order"] == "subscription") { ?>
					<script>
						insertAlert('Vous devez posséder un abonnement', false);
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