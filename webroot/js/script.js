$(document).on('click', '#menu', function(){
	$('#sidebar').toggleClass('active');
	$('#sidebar a').toggleClass('noactive');
	$('.others_links a').addClass('noactive');
	$('.container').toggleClass('sidebar_opened');
	$(this).toggleClass('active');
});

var getUrlParameter = function getUrlParameter(sParam) {
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	sURLVariables = sPageURL.split('&'),sParameterName,i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : sParameterName[1];
		}
	}
};

// Désactive turbolinks pour l'email builder (Genère sinon erreur de librairie)
$(document).ready(function(){
	if (getUrlParameter('action') == 'email_builder') {
		$('body').attr('data-turbolinks', 'false');
	}
});

$(document).ready(function(){
	if (getUrlParameter('module') == 'user'){
		var action = getUrlParameter('action');
		$('[href="?module=user&action='+action+'"]').addClass('active');
	}
});

function search_blur(){
	$('#form-search-js').removeClass('focus');
	$('#search').val('');
}

document.addEventListener("turbolinks:load", function() {

	if ($("#sidebar").hasClass("active")){
		$('.container').addClass('sidebar_opened');
	}
	else {
		$('.container').removeClass('sidebar_opened');
	}


	$( "#search" ).focus(function(e) {
		$('#form-search-js').addClass('focus');
	});

	$(document).on('click', '.link_container div a', function(){
		$target = $(this);
		if (!$target.attr('data-appened')) {
			$('.link_container div a').removeAttr('data-appened');
			$target.attr('data-appened', 'true');
			$('.link_container div a').removeClass('active');
			$target.addClass('active');
		}
	});


	// Hide notif
	$(document).ready(function(){
	    $(".notif").delay(3000).hide("fast");
	});

/*===================================
=            Emails_page            =
===================================*/

	// Slider
  	$( ".arrow_slider" ).click(function() {
  		const width_block = $('.block').width();
  		const margin_block = $('.block').css('margin-left').replace('px', '');
		const brother = $(this).closest("div");
		const overflow = brother.find(".overflow");
		const position = $(overflow).position();	
		let position_left = position.left;
		let position_left_r = position.left;
		const nb_block = overflow.find('.block').length;
		const taille = nb_block * (width_block + (2*margin_block));
		const list = brother.find('.list').width();
		const block_number = Math.trunc(list / (width_block + (2*margin_block)));
		const autorise_dep = (nb_block - block_number) * (-195);

		if ($(this).hasClass('arrow_right')) {
			if (position_left > autorise_dep) {
				if ((position_left / 195 == Math.trunc(position_left / 195))) {
					position_left = position_left - 195;
					$(overflow).css({
						"left":position_left+ 'px'
					});

					if (position_left == autorise_dep) {
						$(this).css({
							'opacity': '0.5'
						});
					}
					else {
						$(this).find('.arrow_left').css({
							'opacity': '1'
						});
					}
				}
			}
		}
		else {
			if (position_left_r < 0) {
				if ((position_left_r / 195 == Math.trunc(position_left_r / 195))) {
					position_left_r = position_left_r + 195;
					$(overflow).css({
						"left":position_left_r + 'px'
					});
				}
				if (position_left_r == 0) {
					$(this).css({
						'opacity': '0.5'
					});
				}
				else {
					$(this).next('.arrow_left').css({
						'opacity': '1'
					});
				}
			}
		}
  	});

	// Open form => Create a categorie
	$(document).on('click', '.span_add', function() {		
		$('.flipper').css({
			transform:"rotateX(-180deg)"
		});
	});

	// Cancel form => Create a categorie
	$(".cancel_flip").click(function() {		
		$('.flipper').css({
			transform:"rotateX(0deg)"
		});
	});

	var flag = true;

	// See toolbox => Delete / Duplicate / Edit
	$(document).on('mouseenter', '.notarchive', function() {
		if (flag) {
			$(this).find('.tools_block').html(
				'<i class="fa fa-pencil-square-o redirect_email" aria-hidden="true"></i>'+
				'<i class="fa fa-trash delete_email" aria-hidden="true"></i>'+
				'<i class="fa fa-clone duplicate_email" aria-hidden="true"></i>'
			);
		}
	});

	// Disappear toolbox => Delete / Duplicate / Edit 
	$(document).on('mouseleave', '.notarchive', function() {
		flag = true;
		$(this).find('.tools_block').html('');
	});

	// Redirection to email_builder ID
	$(document).on('click', '.redirect_email', function(){
		if (!$(this).attr('data-redirect')) {
			$(this).attr('data-redirect', 'true');
			let $block = $(this).parents('.block');
			let $id = $block.attr('id');
			const $link = '?module=user&action=email_builder&id='+$id+'';
    		window.open($link, "_self");
		}
	});

	// Delete email
	$(document).on('click', '.delete_email', function(event) {

		flag = false;

		var $block = $(this).parents('.block');

		$block.find('.tools_block').html(
			'<span class="tools_delete" id="move_to_archive">Archiver</span>'+
			'<span class="tools_delete" id="delete_mail">Supprimer</span>'
		);
		$block.find('.tools_block').children().animate({
	    		'opacity': '1'
	  		}, 300 , function(){});

	});

	// Confirmation ==> Delete email
	$(document).on('click', '#delete_mail', function() {
		if (!$(this).attr('data-deleted')) {
			$(this).attr('data-deleted', 'true');
			var block = $(this).parents('.block');
			var id_email = block.attr('id');

			$.post( "?module=user&action=index", { email_id_tdelete: id_email }, function() {
				$(block).addClass('disapear');
				setTimeout(function(){
					$(block).remove();
				}, 300);
				$('.overlay').css({
					'background-color': 'rgba(255,255,255,0.4)'
				});
			});
			console.log('delete done');
		}
	});

	// Confirmation ==> Move to archive
	$(document).on('click', '#move_to_archive', function() {
		if (!$(this).attr('data-moved')) {
			$(this).attr('data-moved', 'true');
			var block = $(this).parents('.block');
			var id_email = block.attr('id');
			$.post( "?module=user&action=index", { email_id_tarchive: id_email }, function() {});
			$(block).addClass('disapear');
			setTimeout(function(){
				$(block).remove();
			}, 300);
			$('.overlay').css({
				'background-color': 'rgba(255,255,255,0.4)'
			});
			console.log('moved done');
		}
	});

	// Duplicate email
	$(document).on('click', '.duplicate_email',function() {
		if (!$(this).attr('data-moved')) {
			$(this).attr('data-moved', 'true');

			let block = $(this).parents('.block');
			let id_mail = block.attr('id');
			let title_old = block.find('.title_mail').html();
			let title_new = title_old+' (copie)';

			$.ajax({
				type: "POST",
				data: { title_new: title_new },
				url : "app/model/user/email/get_infos.php?id="+id_mail, 
				success : function(data) {
					$(block).clone().insertAfter(block).css('opacity', '0').fadeTo('fast', 1);

					var duplicate = block.next();
					duplicate.removeAttr('data-duplicate').data('data-turbolinks-permanent', 'true');
					var title_copie = duplicate.find('.title_mail').html();
					duplicate.find('.tools_block').html('');
					duplicate.find('.title_mail').html(title_copie+' (copie)');

					duplicate.attr('id', data);
				}
			});
			console.log('duplicated done');
		}	
	});

	// Drag & Drop
	function sortable(){
	    $( ".sortable" ).sortable({
		    revert: 75,
		    opacity: 0.35,
		    refreshPositions:true,
		    connectWith: ".active .list .sortable",
		    placeholder: "ui-state-highlight",
		   	cursor: "move",
		   	start: function(){
		   		$(this).parents('.cat').css({overflow: 'visible'});
		   		// $('.cat').on('mouseover',function(){
		   		// 	$(this).find('.row_list_email').addClass('active');
		   		// });
		   		// $('.cat').on('mouseout',function(){
		   		// 	$(this).find('.row_list_email').removeClass('active');
		   		// });
		   	},
		   	receive: function (event,ui) {
		   		var cat_id = $(this).parents('.cat').attr('id');
		   		var email_id = $(ui.item).attr("id");
		   		$.post( "?module=user&action=index", { id_cat: cat_id, email_id_tupdate: email_id }, function() {});
		   	},
		   	stop: function(){
		   		$(this).parents('.cat').css({overflow: 'hidden'});
		   	},
			// forceHelperSize: true,
	    });
	    $( ".sortable, .row_list_email" ).disableSelection();
 	};
	$(document).ready(function(){
		sortable();
	});
	
	// Edit categorie
	$(document).on('click', '.pencil', function (){
		if (!$(this).attr('data_open_update_cat')) {
			$(this).attr('data_open_update_cat', 'true');
			console.log('test');
			const title = $(this).parent().parent().find('.h2');
			const textInput = $(this).parent().parent().find('.input');
			const textValue = textInput.val();
			
			title.removeClass('active');
			textInput.addClass('active');
			textInput.val(textValue).focus();

			$(this).parent().html(
				'<span class="tools_action_title_btn save"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>'+
				'<span class="tools_action_title_btn cancel" ><i class="fa fa-times-circle" aria-hidden="true"></i></span>'
			);
		};
	});

	// Cancel edit categorie
	$(document).on('click', '.cancel', function (){
		let title = $(this).parent().parent().find('.h2');
		let textInput = $(this).parent().parent().find('.input');
		
		title.addClass('active');
		textInput.removeClass('active');

		$(this).parent().html(
			'<span for="cat_name" class="tools_action_title_btn pencil"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>'+	
			'<span for="cat_name" class="tools_action_title_btn trash"><i class="fa fa-trash-o" aria-hidden="true"></i></span>'		
		);
	});

	// Save edit categorie
	$(document).on('click', '.save',function (){
		let id = $(this).parents('.cat').attr('id');
		let title = $('#'+id).find('.h2');
		let textInput = $('#'+id).find('.input');
		var textValue = textInput.val();
		let cat_number = $(this).parents('.cat').index() - 1;

		if (textValue == '') {
			textValue = 'Categorie '+cat_number;
		}

		$.post( "?module=user&action=index&cat_id="+id, { cat_name: textValue }, function() {});

		$(this).parent().html(
			'<span for="cat_name" class="tools_action_title_btn pencil"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>'+	
			'<span for="cat_name" class="tools_action_title_btn trash"><i class="fa fa-trash-o" aria-hidden="true"></i></span>'
		);

		title.addClass('active').html(textValue);
		textInput.removeClass('active');
	});

	// Create categorie
	$("#new_cat").submit(function() {

		let numberOfCat = $('.cat').length + 1;
		let catInput = $('#categorie_name').val();
		let catName = '';

		if (catInput == '') { catName = 'Categorie '+numberOfCat; }
		else { catName = catInput; }

		$.post( "?module=user&action=index", { cat_name: catName }, function() {

		})
		.done(function(respons) {
			let block_cat =
			'<div class="block_rows cat" id="'+respons+'" style="max-height:0px; opacity:0;">'+
			'<div class="column_title_block">'+
			'<div class="title">'+
			'<div class="modif-cat-form">'+
			'<input class="input" type="text" name="cat_name" value="'+catName+'">'+
			'<h2 class="h2 active">'+catName+'</h2>'+
			'<div class="tools_action_title_box">'+
			'<span class="tools_action_title_btn pencil"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>'+
			'<span class="tools_action_title_btn trash"><i class="fa fa-trash-o" aria-hidden="true"></i></span>'+
			'</div>'+
			'</div>'+
			'<span class="accordeon active"><i class="fa fa-angle-down" aria-hidden="true"></i></span>'+
			'</div>'+
			'<div class="row_list_email active">'+
			'<span class="arrow"><i class="arrow_slider arrow_left fa fa-arrow-circle-left" aria-hidden="true"></i></span>'+
			'<div class="list">'+
			'<div class="overflow sortable">'+
			'</div>'+
			'</div>'+
			'<span class="arrow"><i class="arrow_slider arrow_right fa fa-arrow-circle-right" aria-hidden="true"></i></span>'+
			'</div>'+
			'</div>'+
			'</div>';

			$(block_cat).insertBefore('.add_section');
			$('.flipper').css({ transform:"rotateX(0deg)" });
			$('.cat').last().animate({
	    		'opacity': '1',
	   		 	'max-height': "281px"
	  		}, 1200 , function(){});	
			sortable();

			$('#categorie_name').val('');
		});
		return false;
	});

	// Open confirmation delete categorie
	$(document).on('click', '.trash', function (){
		if (!$(this).attr('data_open_btn_cat')) {
			$(this).attr('data_open_btn_cat', 'true');

			const $row_cat = $(this).parents('.cat');
			const $cat_id = $row_cat.attr('id');
			const $nb_block = $row_cat.find('.block').length;
			console.log($nb_block +' block(s)');

			var $message = '';
			var $block_btn = '';

			function add_confirmation(){
				 $block_btn = 
					'<p class="confirmation_delete_cat">Etes-vous sur ? '+$message+'.&nbsp;'+
					'<a href="#" id="btn_delete_cat" title="">Confirmer</a> '+		
					'<a href="#" id="btn_cancel_delete_cat" title="">Annuler</a>'+
					'</p>';
			}

			if ($nb_block == 0) {
				$.post( "?module=user&action=index", { cat_id:$cat_id }, function() {})
				.done(function() {
					$($row_cat).animate({
			    		'opacity': '0',
			   		 	'max-height': "0px"
			  		}, 1200 , function() {
						$($row_cat).remove();
			  		});	
				});
			}

			if ($nb_block == 1) {
			 	$message = '<u>L\'email sera également supprimé</u>';
			 	add_confirmation();
				$(this).parent().html($block_btn);
			} 

			if ($nb_block > 1) {
				$message = 'Les <u>'+$nb_block+' emails seront également supprimés</u>';
				add_confirmation();
				$(this).parent().html($block_btn);
			} 
			
			console.log('clic on trash');
		} 
	});

	// Confirm confirmation delete Cat
	$(document).on('click', '#btn_delete_cat', function(event){
		if (!$(this).attr('data_delete_cat')) {
			$(this).attr('data_delete_cat', 'true');

			let row_cat = $(this).parents('.cat');
			let cat_id = row_cat.attr('id');

			$.post( "?module=user&action=index", { cat_id:cat_id }, function() {})
			.done(function() {
				$(row_cat).animate({
		    		'opacity': '0',
		   		 	'max-height': "0px"
		  		}, 1200 , function() {
					$(row_cat).remove();
		  		});	
			});
			event.preventDefault();
		}
	});

	// Cancel confirmation delete Cat
	$(document).on('click', '#btn_cancel_delete_cat', function(event){
		if (!$(this).attr('data_cancel_delete_cat')) {
			$(this).attr('data_cancel_delete_cat', 'true');

			$(this).parent().html(
				'<span for="cat_name" class="tools_action_title_btn pencil"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>'+	
				'<span for="cat_name" class="tools_action_title_btn trash"><i class="fa fa-trash-o" aria-hidden="true"></i></span>'		
			);
		}
	});

	// Show categorie
	$(document).on('click', '.accordeon', function(){
		if (!$(this).attr('data_open_cat')) {
			if (!$(this).hasClass('active')) {
				$(this).removeAttr('data_closed_cat');
				$(this).attr('data_open_cat', 'true');
				let $arrow = $(this);
				let $list = $arrow.parents('.column_title_block').find('.row_list_email');

				$list.addClass('active');
				$arrow.addClass('active');
				setTimeout(function(){
					$list.addClass('overflow');
					// alert('hello');
				},500);
			}
		}
	});
	$(document).on('click', '.accordeon.active', function(event){
		if (!$(this).attr('data_closed_cat')) {
			$(this).removeAttr('data_open_cat');
			$(this).attr('data_closed_cat', 'true');
			
			let $arrow = $(this);
			let $list = $arrow.parents('.column_title_block').find('.row_list_email');

			$list.removeClass('active');
			$arrow.removeClass('active');
			setTimeout(function(){
				$list.removeClass('overflow');
				// alert('hello');
			},500);
		}	
	});

/*=====  End of Emails_page  ======*/

/*====================================
=            Archives page           =
====================================*/

	// Select one block
	$(document).on('click', '.checkbox.nocheck', function(){
		console.log('touch block');
		$(this).removeClass('nocheck').addClass('check');
		$(this).parents('.block').addClass('active');
		$('#select_all_archives').removeClass('disabled');
		$('#deselect_all_archives').removeClass('disabled');

		let nbActive = $('.active.block').length;

		if (nbActive == 0) {
			$('.btn_action').addClass('disabled');
		} else {
			$('.btn_action').removeClass('disabled');
		}
		if (nbActive == $('.block').length) {
			$('#select_all_archives').addClass('disabled');
		}
	});

	// Deselect one block
	$(document).on('click', '.check.checkbox', function() {
		$(this).addClass('nocheck').removeClass('check');
		$(this).parents('.block').removeClass('active');

		let nbActive = $('.active.block').length;

		if (nbActive == 0) {
			$('.btn_action').addClass('disabled');
			$('#deselect_all_archives').addClass('disabled');
			$('#select_all_archives').removeClass('disabled');
		} 
		else {
			$('.btn_action').removeClass('disabled');
		}
	});

	// Select all blocks
	$(document).on('click', '#select_all_archives', function(){
		$('.btn_action').removeClass('disabled');
		if ($(this).hasClass('disabled')) {
			return false;
		}
		$('#deselect_all_archives').removeClass('disabled');
		$(this).parents('.column_title_block').find('.block').addClass('active');
		$(this).addClass('disabled');
		$('.checkbox').addClass('check').removeClass('nocheck');
	});

	// Deselect all blocks
	$(document).on('click', '#deselect_all_archives', function(){
		$('.btn_action').addClass('disabled');
		$('.checkbox').addClass('nocheck').removeClass('check');
		$('#select_all_archives').removeClass('disabled');
		if ($(this).hasClass('disabled')) {
			return false;
		}
		$(this).parents('.column_title_block').find('.block').removeClass('active');
		$('#deselect_all_archives').addClass('disabled');
	});

	function Soustraction(Number) {
		x = parseInt($('#nb_archives').html().substr(1,1));
		y = x - Number;
		$('#nb_archives').html('('+y+')');
	}

	// Restore Email
	$(document).on('click', '#restore_email', function(){
		$selected = $('.active.block');
		if ($(this).hasClass('disabled')) {
			return false;
		} else {
			var sizeEmail = [];
			let nbActive = $selected.length;
			for (var i = nbActive - 1; i >= 0; i--) {
				sizeEmail.push($selected.eq(i).attr('id'));
				if (i == 0) {
					var jsonString = JSON.stringify(sizeEmail);
					$.ajax({
						type: "POST",
						data: {data_restore : jsonString},
						url : "?module=user&action=archives",
						success : function() {
							$selected.addClass('disapear');
							setTimeout(function(){
								$selected.remove();
							}, 300);
						}
					});
					$('.btn_action').addClass('disabled');
					$('#deselect_all_archives').addClass('disabled');
				}
			}
			Soustraction(nbActive);
		}
	});

	// Delete Email
	$(document).on('click', '#delete_email', function(){
		$selected = $('.active.block');
		if ($(this).hasClass('disabled')) {
			return false;
		} else {
			var sizeEmail = [];
			let nbActive = $selected.length;
			for (var i = nbActive - 1; i >= 0; i--) {
				sizeEmail.push($selected.eq(i).attr('id'));
				if (i == 0) {
					var jsonString = JSON.stringify(sizeEmail);
					$.ajax({
						type: "POST",
						data: {data_delete : jsonString},
						url : "?module=user&action=archives",
						success : function() {
							$selected.addClass('disapear');
							setTimeout(function(){
								$selected.remove();
							}, 300);
						}
					});
					$('.btn_action').addClass('disabled');
					$('#deselect_all_archives').addClass('disabled');
				}
			}
			Soustraction(nbActive);
		}
	});

/*=====  End of Archives page  ======*/


/*======================================
=            Templates_page            =
======================================*/

	// Show popup ==> Request template
	$( ".action_creat_temp" ).click(function() {		
		$(".creat_template").css({
			visibility:"visible",
			opacity:"1",
		});
	});

	// Hide popup ==> Request template
	$( ".popup-overlay" ).click(function() {		
		$(".popup-overlay, .popup-container").css({
			visibility:"hidden",
			opacity:"0",
		});
	});

	// Show popup ==> Loot at template
	$( ".see_template" ).click(function() {
		$(".see_email_template_block").load("?module=user&action=template&id="+$(this).attr("id"));				
		$(".template_email, .creat_email").css({
			visibility:"visible",
			opacity:"1",
		});
		$('.creat_email').attr('href', '?module=user&action=email_builder&template='+$(this).attr("id")+'');
	});

	// Hide popup ==> Look at template
	$(".template_email").click(function() {
		$('.template_email, .creat_email').css({
			visibility:"hidden",
			opacity:"0",
		});
	});

	// Not hidding ==> Look at template
	$('.see_email_template_block').click(function () {
		event.stopPropagation();	
	});

/*=====  End of Templates_page  ======*/

/*======================================
=            Commandes_page            =
======================================*/

	$(".row_data_commande").click(function() {
		$(".popup-overlay, .popup-container").css({
			visibility:"visible",
			opacity:"1",
		}).show();
	    $(".commande").load("?module=admin&action=commandes&id="+$(this).attr("id"));
	});

	// Show confirmation ==> update order
	$(document).on('click', '#valide_order', function (){
		$btn = $(this);
		$footer = $btn.parent('footer');
		$footer.html(
			'<p style="margin-bottom:16px;">Confirmer et envoyer un email à l\'utilisateur ?</p>'+
			'<button class="valide button_default confirm">'+
			'<span class="buttoneffect"></span>'+
			'<span class="text-cta">Je confirme</span>'+
			'</button>'
		);
		$footer.addClass('confirmation');
	});

	// Update confirmation post ==> Order supported
	$(document).on('click', '.confirm', function (){
		const $footer = $(this).parent('footer');
		let $id_commande = $footer.attr('id');
		$footer.html('<div class="loader_popup"><span></span></div>');
		$.post( "?module=admin&action=commandes", { order: $id_commande }, function(html) {
			$footer.html(
				'<p style="font-size:17px;">Prise en charge effectuée !</p>'
			);
			$('.td_'+$id_commande).html(
				'<span class="label statut1">Prise en charge</span>'
			);
			$('#statut_change').html(
				'<span class="label statut1">Prise en charge</span>'
			);
		});
	});

	// Update confirmation post ==> Order finished
	$(document).on('click', '#finish_order', function () {
		const $parent = $(this).parents('.commande');
		$parent.load("?module=admin&action=commandes&id_commande="+$(this).parent().attr("id"));
	});

	$(document).on('click', '.valideorder', function(e) {

		e.preventDefault();
		e.stopPropagation();
		 
        var $form = $('#finishOrder');
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
		var idOrder = $('#OrderID').val();
		var dom = $('#DOM').val();
		var medias = $('#mco_template_mobile').val();

		const $footer = $(this).parents('footer');
		$footer.html('<div class="loader_popup"><span></span></div>');
        $.ajax({
            url: "?module=admin&action=commandes",
            type: "POST",
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data,
            complete: function (html) {
                var newDom = dom.replace(new RegExp('images/', 'g'), html.responseText);
				$footer.html('<button id="'+idOrder+'" class="completeorder button_default">'+
				'<span class="buttoneffect"></span>'+
				'<span class="text-cta">Valider le template</span>'+
				'</button>');
				$('.popup-container header').hide();
               	$('.popup-container.commande .content_block ').html(newDom);
               	$(document).on('click', '.completeorder', function(event) {
               		event.preventDefault();
               		event.stopPropagation();
               		$('.content_block.popup-blocks [data-section]').each(function(){
						var id = Math.floor(Math.random() * 16777215).toString(16);
					    $(this).attr('data-section', id);
						var section = $('[data-section="'+id+'"]');
						cheminImage = html.responseText;
						cheminThumbs = cheminImage.replace('images', 'thumbnails');
						html2canvas(section, {
							onrendered: function(canvas) {
								$.ajax({
				                    type: "POST",
				                    data: {thumb: canvas.toDataURL("image/png"), nameThumb: id, chemin: cheminThumbs },
				                    url : "?module=admin&action=commandes",
				                    complete : function(html) {
				                    	// console.log(html.responseText);
				                    }
				                });
							}
						});
					})
					.promise().done(function () { 
						var idUser = cheminImage.split('/');
						idUser = idUser[1].replace(/\D+/g, '');
						dom = $('.popup-container.commande .content_block ').html();
					    $.ajax({
		                    type: "POST",
		                    data: {addToBdd: idOrder, DOM: dom, mco_template_mobile: medias, userId: idUser },
		                    url : "?module=admin&action=commandes",
							success: function(data) {
								$('.td_'+idOrder).html(
									'<span class="label statut2">Terminée</span>'
								);
								$(".popup-overlay, .popup-container").css({
									visibility:"hidden",
									opacity:"0",
								});
							},
		                });
					});
					return false;
               	});
            }
        });
		
		return false;
	});

/*=====  End of Commandes_page  ======*/

/*====================================
=            Account_page            =
====================================*/

	// Post Update
	$( "#form__modif_user_account" ).submit(function() {
		let first_name = $('#first_name').val();
		let last_name = $('#last_name').val();
		let societe = $('#societe').val();
		let nb_phone = $('#nb_phone').val();
		let myArray = [first_name, last_name, societe, nb_phone];

		$('.loader_post').css({
			visibility:"visible",
			opacity: "1.0",
		});

		$.post("?module=user&action=modif",{ 	
			first_name: first_name,
			last_name: last_name,
			societe: societe,
			nb_phone: nb_phone
		})
		.done(function() {
			$('.loader_post').css({
				visibility:"hidden",
				opacity: "0",
			});
		});
		return false;
	});
	/*=====  End of Account_page  ======*/
});