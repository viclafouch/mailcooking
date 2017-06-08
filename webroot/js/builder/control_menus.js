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

	$('.choose_color_background').minicolors({
		change: function(value) {
    		$('#storage_email, .content_email').css('background-color', value);

  		},
	});

	$('.choose_color').parent().addClass('btn_tools');

	$(document).on('click', '.btn_tools', function(){
		$(this).addClass('active');
		$(this).children('input').focus();
		return false;
	});

	$(document).on('click', '.full_container', function(event){
		$('.btn_tools').removeClass('active');
	});

	$(document).on('click', '.btn_change_action_border', function(){
		$('.btn_change_action_border').removeClass('active');
		$(this).addClass('active');
	});

	$(document).on('click', '.flipper', function(){
		$('.flipper').css('z-index', '0');
		$(this).css('z-index', '1');
	});
	
	$(document).on('click', '#change_color_border', function() {		
		$('.flipper').css({
			transform:"rotateX(-180deg)"
		});
	});

	$(document).on('click', '#change_size_border', function() {		
		$('.flipper').css({
			transform:"rotateX(0deg)"
		});
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