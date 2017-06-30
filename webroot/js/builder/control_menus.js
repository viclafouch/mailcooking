/*========================================
=            Contrôle du menu            =
========================================*/

/**
    *
    * Librairie : JQuery
        - JS : lib/js/jquery
        - CSS : null
        - Github : https://github.com/jquery/jquery
        - Documentation : http://api.jquery.com/
    * 
    * Librairie : jQuery MiniColors
        - JS : lib/js/jquery-minicolors
        - CSS : lib/css/jquery-minicolors
        - Github : https://github.com/claviska/jquery-minicolors
        - Documentation : http://labs.abeautifulsite.net/jquery-minicolors/
    *
    *
*/

/*----------  Variables  ----------*/

inEdit = false; // Statut des items du builder

/*----------  Functions  ----------*/
/*----------  Actions  ----------*/

$(document).ready( function() {

	var minicolor;

	$('#background_email').minicolors({
		change: function(value) { 
			$('#storage_email').css('background-color', value); 
		},
	});

	$('.choose_color').minicolors();

    $('.change_number').spinner({ icons: { down: "custom-down-icon", up: "custom-up-icon" } });

    $('.custom-down-icon').html('<i class="signe material-icons">remove</i>');
    $('.custom-up-icon').html('<i class="signe material-icons">add</i>');

	$('.choose_color').parent().addClass('minicolors_before');

	$('.field_item_sidebar').hide();

	$(document).on('click', '.minicolors_before', function(){
		$(this).addClass('active');
		$(this).children('input').focus();
	});

	$(document).on('click', '.map_block .minicolors', function() {
		$('.map_block').css('z-index', '0');
		$(this).parents('.map_block').css('z-index', '1');
	});

	$(document).on('click', '[data-flipper]', function(e){
		$('[data-flipper]').removeClass('active');
		$(this).addClass('active');

		let id = $(this).data('item');
		if ($(this).data('flipper') == 'front') {
			$('#'+id+' .flipper').removeClass('active');
		} else {
			$('#'+id+' .flipper').addClass('active');
		}
	});

	$(document).on('click', '[data-menu]', function() {
		$('[data-menu]').removeClass('active');
		$(this).addClass('active');

		let id = $(this).attr('id');

		$('[data-task]').removeClass('active');
		$('[data-task="'+id+'"]').addClass('active');

		if (id == 'items_sidebar' && inEdit == false) {
			if (!inEdit) {
				$('[data-task]').removeClass('active');
				$('[data-task="notask"]').addClass('active');
			} else {
				$('[data-task="'+id+'"]').addClass('active');
			}
		}
	});
});

/*=====  End of Contrôle du menu  ======*/