				</section>
			</div>
		</main>
		<?php 
			if ($_GET['action'] == 'email_builder') { ?>

				<!-- LIB -->
				<script src="lib/js/jquery/jquery-3.1.1.min.js" type="text/javascript"></script>
				<script src="lib/js/medium-editor/medium-editor.min.js" type="text/javascript"></script>
				<script src="lib/js/croppie/croppie-2.4.1.min.js" type="text/javascript"></script>
				<script src="lib/js/filesaver/filesaver.min.js" type="text/javascript"></script>
				<script src="lib/js/undo-manager/undo-manager.js" type="text/javascript"></script>
				<script src="lib/js/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

				<!-- CUSTOM -->
				<script src="webroot/js/builder/edit_items.js" type="text/javascript"></script>
				<script src="webroot/js/builder/edit_img.js" type="text/javascript"></script>
				<script src="webroot/js/builder/edit_text.js" type="text/javascript"></script>
				<script src="webroot/js/builder/control_sections.js" type="text/javascript"></script>
				<script src="webroot/js/builder/actions_build.js" type="text/javascript"></script>
			<?php }
		?>
	</body>
</html>