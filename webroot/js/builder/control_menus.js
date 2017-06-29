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
/*----------  Functions  ----------*/
/*----------  Actions  ----------*/

$(document).ready( function() {

	var minicolor;

	$('#background_email').minicolors({
		change: function(value) { 
			$('#storage_email').css('background-color', value); 
		},
	});

	$('.choose_color').minicolors({
		show: function(){ minicolor = true },
		hide: function(){ $('.map_block').css('z-index', '0'); minicolor = false; }
	});

    $('.change_number').spinner({ icons: { down: "custom-down-icon", up: "custom-up-icon" } });

    $('.custom-down-icon').html('<i class="signe material-icons">remove</i>');
    $('.custom-up-icon').html('<i class="signe material-icons">add</i>');

    // $('.field_tools_item_block').hide();

	$('.choose_color').parent().addClass('minicolors_before');

	$(document).on('click', '.minicolors_before', function(){
		$(this).addClass('active');
		$(this).children('input').focus();
	});

	$(document).on('mouseenter', '.map_block .minicolors', function() {
		$(this).parents('.map_block').css('z-index', '1');
	});

	$(document).on('click', 'body', function() {
		if (minicolor) {
			$('.map_block').css('z-index', '0');
			minicolor = false;
		}
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

	$(document).on('click', '.btn_menu_builder', function() {
		$('.btn_menu_builder').removeClass('active');
		$(this).addClass('active');

		var $id = $(this).attr('id').replace('_builder', '');

		$('.task').removeClass('menuactive');
		if ($('.'+$id+'_builder_block').height() == 0) {
			$('.todo').addClass('menuactive');
		}
		else {
			$('.'+$id+'_builder_block').addClass('menuactive');
		}
	});
});

/*=====  End of Contrôle du menu  ======*/