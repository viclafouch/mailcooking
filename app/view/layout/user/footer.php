				</section>
			</div>
		</main>
		<div class="popup_mc alert <?php if (isset($_GET['message'])): ?>
			active
		<?php endif; ?>" id="popupAlert">
			<?php if (isset($_GET['message'])): ?>
	 			<p id="messageToUser" style="color: <?php if ($_GET['notif'] != 0): ?>red;<?php else: ?>green <?php endif; ?>;">
 					<?php if ($_GET["message"] == "ordervalide"): ?>
 						Commande envoyée !
 					<?php endif; ?>
 					<?php if ($_GET["message"] == "ordermax"): ?>
 						Vous avez atteint le nombre max de templates
 					<?php endif; ?>
 					<?php if ($_GET["message"] == "subscription"): ?>
 						Vous devez posséder un abonnement
 					<?php endif; ?>
 					<?php if ($_GET["message"] == "paiement"): ?>
 						Une erreur lors du paiement est survenue
 					<?php endif; ?>
	 			</p>
	 		<?php else: ?>
	 			<p id="messageToUser"></p>
	 		<?php endif; ?>
 		</div>
		<script src="webroot/js/min/script.min.js" type="text/javascript"></script>

		<?php if ($_GET['action'] == 'email_builder'): ?>
				<script src="webroot/js/builder.js" type="text/javascript"></script>
		<?php endif; ?>
	</body>
</html>