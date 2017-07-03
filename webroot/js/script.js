/*=============================================
=            Script de Mailcooking            =
=============================================*/

/**
    *
    * Librairie : JQuery
        - JS : lib/js/jquery
        - CSS : null
        - Github : https://github.com/jquery/jquery
        - Documentation : http://api.jquery.com/
    * 
    *
*/

/*----------  Variables  ----------*/

var actionUrl; // Paramètre 'action' de l'url
var popupAction = false // Statue d'une popup d'action de template
var pen = '<i class="material-icons" data-editable-title>create</i>'; // Crayon d'edition de titre
var trash = '<i class="material-icons" data-delete-section>delete</i>'; // Poubelle de suppression
var titleListEmail = '<p><span spellcheck="false" onpaste="return false" class="title_row"></span></p>'; // Titre d'une section
var clicOnPen = false; // Statut du clic sur un crayon d'edition
var title; // Titre d'edition de template
var contentTitle; // Valeur du titre
var flagAdd = true // Etat du bouton ajout d'informations

/*----------  Fonctions  ----------*/

/**
    Séléctionnez le titre puis CTRL+D (Windows) ou CMD+D (Mac).
    - I     :  Activation/Desactivation de la sidebar
    - II    :  Récupération des paramètres d'URL
    - III   :  Désactive Scroll (via I & II);
    - IV    :  Active Scroll
    - V     :  Récupère les paramètres d'URL
    - VI    :  Création du Cropper
    - VII   :  Insertion d'un nouveau fichier
    - VIII  :  Sauvegarde des modifications
    - IX    :  Annule des modifications
    - X     :  Constructeur
**/

// I : Activation/Desactivation de la sidebar 
function activateSidebar(btn) {
	$('#sidebar').toggleClass('active');
	$('#sidebar a').toggleClass('noactive');
	$('.others_links a').addClass('noactive');
	$('.large_container, .navigation').toggleClass('sidebar_opened');
	$(btn).toggleClass('active');
}

// II : Récupération des paramètres d'URL
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

var idEmail = function getEmailInfo(element) {
	var idEmail = $(element).parents('li').data('email');
	return idEmail;
}

function displayOfActionsTemplate(btn) {
	$('[data-opened]').css('height', '0px')
	$('[data-opened] ul').css({
		opacity:'0',
		visibility: 'hidden'
	});
	$('[data-opened]').removeAttr('data-opened');
	popupActionTemplate = $(btn).parent().next();
	$(popupActionTemplate).attr('data-opened', 'true');
	popupActionTemplate.css('height', 'auto');
	$(popupActionTemplate).children('ul').css({
		opacity:'1',
		visibility: 'visible'
	});
}

function hidePopup(popup) {
	$(document).on('click', '.popup_background, [data-close-popup]', function(){
		popup.removeClass('active');		
	});
}

/*----------  Actions  ----------*/

// Démarrage des modules sans turbulinks
$(document).ready(function(){
	/* Ces évènements ci-dessous n'ont pas besoin d'être
	rechargé à chaque changement de page.
	Exemple avec un console.log, celui ne s'affichera
	qu'une fois sur votre site même en changeant de page.
	*/

	/* Activation/Desactivation de la sidebar */
	$(document).on('click', '#menu', function(){
		activateSidebar(this);
	});

	/* Affiche l'alerte */
	$('.alert').animate({
		bottom: '25px',
		top: 'auto'
	}, 1000);

	/* Cache l'alerte */
	setTimeout(
		function() {
			$('.alert').animate({
				top: '100%',
			}, 1000);
		},
		5000
	);
	
	/* Empêche (pour le moment) l'envoi du formulaire de recherche */
	$(document).on('submit', '#searchForm', function(event){
		event.preventDefault();
		return false;
	});

	/* Active le formulaire de recherche */
	$(document).on('focus', '#searchForm input', function() {
		$('#searchForm').addClass('focus');
	});

	/* Désactive le formulaire de recherche */
	$(document).on('blur', '#searchForm input', function(){
		$('#searchForm').removeClass('focus');
		$(this).val('');
	});
	
	/* Check l'url pour la désactivation turbolinks pour le builder */
	if (getUrlParameter('action') == 'email_builder') {
		$('body').attr('data-turbolinks', 'false');
	}

	/* Check l'url pour l'activation du menu */
	if (getUrlParameter('module') == 'user'){
		actionUrl = getUrlParameter('action');
		$('[href="?module=user&action='+actionUrl+'"]').addClass('active');
	}

	/* Active la preview des templates */
	$(document).on('click', '[data-popup-preview]', function(){
		let parent =  $(this).parents('.li_template');
		let idTemplate = parent.data('template');
		let userAllow = parent.data('allow');
		let popup = $('#templatePreview');
		if (userAllow == 0) {
			$("#templatePreview .popup_container").load("?module=user&action=template&id="+idTemplate+"&allow=0");	
		} else {
			$("#templatePreview .popup_container").load("?module=user&action=template&id="+idTemplate+"&allow="+userAllow);	
		}			

		popup.addClass('active');

		$(document).on('click', '#templatePreview a', function(e) {
			e.preventDefault();
		});

		hidePopup(popup);
	});

	/* Active le formulaire de création de commande */
	$(document).on('click', '[data-popup-order]', function(){
		let popup = $('#templateOrder');

		popup.addClass('active');

		hidePopup(popup);
	});

	/* Navigation dans le menu du profil */
	$(document).on('click', '[data-link-profil]', function(e){
		e.preventDefault();
		$('.bg_field').removeClass('active');	
		$('.info_accordeon').removeClass('active').css('height', '0px');
		$('.link_block').removeClass('active');
		$(this).parent().addClass('active');
		let menu = $(this).data('link-profil');
		$('[data-task]').hide();
		$('[data-task="'+menu+'"]').show();
	});

	/* Clic sur les paramètres de compte */
	$(document).on('click', "[data-info]", function(e){
		e.preventDefault();
		let id = $(this).attr('data-info');
		let accordeon = $('#'+id);

		if (accordeon.hasClass('active')) {
			$(this).parents('.bg_field').removeClass('active');	
			accordeon.css('height', '0px');
			accordeon.removeClass('active');
		}

		else {
			$('.bg_field').removeClass('active');	
			$(this).parents('.bg_field').addClass('active');
			$('.info_accordeon').removeClass('active').css('height', '0px');
			var h = $('#'+id+" > div").height();
			accordeon.css('height', h+'px');
			accordeon.addClass('active');
		}		
	});

	function incrementeNumber(id) {
		let list = '#'+id+'_list';
		let length = $(list+' li').length - 1;
		$('[data-count="'+id+'"]').html(length);
	}

	/* Supprime une ligne d'un field */
	$(document).on('click', '[data-delete]', function(e){
		e.preventDefault();
		let data = $(this).data('delete');
		let accordeon = $('#'+data);
		let h = parseFloat(accordeon.css('height'));
		let list = '#'+data+'_list';
		let length = $(list+' li').length - 1;
		var row = $(this).parents('li');
		if (flagAdd) {
			if (length > 1) {
				row.css('height', '0px');
				accordeon.css('height',  h - 51+'px');
				$('[data-count="'+data+'"]').html(length - 1);
				setTimeout(function(){
					row.remove();
				}, 800);
			} else {
				console.log('mettre au moins 1 société');
			}
		}
	});

	$(document).on('click', '[data-add]', function(e){
		e.preventDefault();
		if (flagAdd) {
			flagAdd = false;
			$(this).addClass('desactivate');
			let id = $(this).data('add');
			let list = '#'+id+'_list';
			let accordeon = $('#'+id);
			let h = parseFloat(accordeon.css('height'));
			accordeon.css('height',  h + 51+'px');
			var row = $(list+' li:first-child');
			let $clone = row.clone(true);
			let inputHTML = '<input placeholder="'+id+'" spellcheck="false" autocomplete"off" type="text" data-input="'+id+'" />'
			let saveHTML = '<a href="#" data-save="'+id+'" title="">Sauvegarder</a>';
			$($clone).find('p:first-child').html(inputHTML);
			$($clone).find('p:last-child').html(saveHTML);
			$($clone).insertBefore($(this).parents('li'));

			$(document).on('click', '[data-save]', function(e){
				e.preventDefault();
				if (id == 'societe') {
					let input = $('[data-input="'+id+'"]');
					let val = input.val();
					let deleteHTML = '<a href="#" data-delete="'+id+'" title="">Supprimer</a>';
					let modifHTML = '<a href="#" data-modif="'+id+'" title="">Modifier</a>';
					if (val != '') {
						incrementeNumber(id);
						input.parent().html(val);
						$(this).parent().html(deleteHTML);
						$('.desactivate').removeClass('desactivate');
						flagAdd = true;
					}
				}
			});

			$(document).on('click', "[data-info]", function(e) {
				e.preventDefault();
				console.log('tests');
				if (!flagAdd) {
					if (id == 'societe') {
						var row = $('[data-input]').parents('li');
						row.css('height', '0px');
						setTimeout(function(){
							row.remove();
						}, 800);
						$('.desactivate').removeClass('desactivate');
					}
					flagAdd = true;
				}
			});
		}
	});

	/* Modification d'un élément de profil */
	$(document).on('click', '[data-modif]', function(e) {
		if (flagAdd) {
			flagAdd = false;
			e.preventDefault();
			var id = $(this).data('modif');
			let saveHTML = '<a href="#" data-save="'+id+'" title="">Sauvegarder</a>';

			if (id == 'prenom') {
				var lastNameText = $('#lastName').text();
				var firstNameText = $('#firstName').text();
				var inputHTML = '<input type="text" data-input="'+id+'" data-value="lastName" value="'+lastNameText+'"/>'+
				'<input type="text" data-input="'+id+'" data-value="firstName" value="'+firstNameText+'"/>';
			}

			$(this).parents('li').find('p:first-child').html(inputHTML).focus();
			$(this).parent().html(saveHTML);

			$(document).on('click', '[data-save]', function(e){
				e.preventDefault();
				if (id == 'prenom') {
					var lastName = $('[data-value="lastName"]').val();
					var firstName = $('[data-value="firstName"]').val();
					
					if (firstName != '' && lastName != '') {
						var modifHTML = '<a href="#" data-modif="'+id+'" title="">Modifier</a>';
						$(this).parents('li').find('p:first-child').html('<span id="lastName">'+lastName+'</span>'+ 
						' <span id="firstName">'+firstName+'</span>');
						$(this).parent().html(modifHTML);	
						flagAdd = true;
					}
				}
			});

			$(document).on('click', "[data-info]", function(e) {
				e.preventDefault();
				if (!flagAdd) {
					if (id == 'prenom') {
						var lastName = $('[data-value="lastName"]').val();
						var firstName = $('[data-value="firstName"]').val();
						if (firstName != '' && lastName != '') {
							$('[data-value]').parent().html('<span id="lastName">'+lastNameText+'</span>'+ 
							' <span id="firstName">'+firstNameText+'</span>');
							let modifHTML = '<a href="#" data-modif="'+id+'" title="">Modifier</a>';
							$('[data-save]').parent().html(modifHTML);
						}
					}
					flagAdd = true;
				}
			});
		}
	});

	/* Active la popup de renouvellement */
	$(document).on('click', '[data-popup]', function(e){
		e.preventDefault();
		let data = $(this).data('popup');
		let popup = $('#'+data);		

		popup.addClass('active');

		hidePopup(popup);
	});

	/* Duplication d'un email */
	$(document).on('click', '#duplicateBuilder', function() {
		var idEmail = $(this).parents('li').data('email');
		var block = $(this).parents('li');
		var rowEmail = block.parents('ul');
		$.ajax({
			type: "POST",
			data: { idEmail: idEmail },
			url : "?module=user&action=emails", 
			success : function(data) {

				let folder = data;
				let idEmail = data.split('_')[0];
				let cloneEmail = block.clone();
				cloneEmail.removeAttr('data-appened');
				cloneEmail.find('[data-toolbox]').html('').removeClass('active');
				cloneEmail.attr('data-email', idEmail);

				src = cloneEmail.css('background').split('/');

				let newSrc = src[0]+'/'+src[1]+'/'+src[2]+'/'+folder+'/'+src[4];
				cloneEmail.css('background', newSrc);
				rowEmail.append(cloneEmail);
			}
		});
	});
});


// Démarrage des modules avec turbolinks.
document.addEventListener("turbolinks:load", function() {
	/* Les modules ci-dessous se rebindent à chaque changement de page.
	Un console.log s'affichera à chaque changement de page.

	Attention, le DOM réinjecté en ajax possède déjà des évènements 
	(exemple un clic). Il est donc nécessaire 'idempotent' vos évènements
	sinon ca va vous multiplier vos actions.

	Exemple : 
	$(document).on('event', 'selector', function(){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			code...
		}
	});
	*/
	
	/* Check l'etat de la sidebar */
	if ($("#sidebar").hasClass("active")){
		$('.large_container, .navigation').addClass('sidebar_opened');
	}
	else {
		$('.large_container, .navigation').removeClass('sidebar_opened');
	}

	/*----------  Templates  ----------*/

	/* Active/montre le menu cliqué */
	$(document).on('click', '.link_container a', function(){
		$target = $(this);
		if (!$target.attr('data-appened')) {
			$('.link_container a').removeAttr('data-appened');
			$target.attr('data-appened', 'true');
			$('.link_container a').removeClass('active');
			$target.addClass('active');
		}
	});

	/* Désactive/cache le menu cliqué */
	$(document).on('click', 'body', function(e){
		if (($(e.target).hasClass('data-action-template'))||($(e.target).is('[data-action-template]'))) {
			btn = $(e.target).closest('[data-action-template]');
			displayOfActionsTemplate(btn);
		}
		else{
			$('[data-opened]').css('height', '0px');
			$('[data-opened] ul').css({
				opacity:'0',
				visibility: 'hidden'
			});
			$('[data-opened]').removeAttr('data-opened');
		}
	});

	/* Changement des selects */
	$(document).on('change', '[data-select-template]', function(e) {
		if ($(this).attr('id') == 'selectDisplayAllow') {
			var allowSelected = $(this).val();
			var dateSelected = $("#selectDisplayDate").val();
		}
		else {
			var dateSelected = $(this).val();
			var allowSelected = $("#selectDisplayAllow").val();
		}

		$.ajax({
			type: "POST",
			data: { templates: allowSelected, orderby: dateSelected },
			url : "?module=user&action=template", 
			success : function(data) {
				$('.list_template ul').html(data);
			}
		});
	});

	/*----------  Emails  ----------*/

	clicOnPen = false;

	function sortableEmailsList() {
	    $('.emails_list').sortable({
	    	connectWith: $('.emails_list'),
	        /* Curseur style quand mouvement en fonctionnement */
	        cursor: 'move',
	        /* Elements pouvant être déplacé */
	        items: "> *",
	        /* Opacité pendant le drag */
	        opacity: 0.90,
	        /* Classe du placeholder */
	        placeholder: "sortable_placeholder_email_list",
	        /* Anime le retour de l'élément au drop */
	        revert: true,
	        /* Z-index de l'élément dragger */
	        zIndex: 9999,
	        tolerance: 'pointer',
	        /* Event drag de n'importe quoi (container même ou autre) */
	        activate: function(event, ui){},
	        /* Event au lachage mais placeholder encore en activité */
	        beforeStop: function(event, ui){
	        },
	        /* Event au changement de l'ordre des éléments (durant le drag) */
	        change: function(event, ui){
	        },
	        /* Event à la création du module (onready) */
	        create: function(event, ui){},
	        /* Event à la fin du sortable */
	        deactivate: function(event, ui){},
	        /* Event lorsqu'un item en mouvement sort du container */
	        out: function(event, ui){
	       		$('[data-appened-hover]').removeAttr('data-appened-hover');
	       		$('[data-editable-title], [data-delete-section]').remove();
	       	},

	        over: function(event, ui){
	        	let parent = $(this).parents('[data-section]');
	        	if (parent.length == 1) {
	        		if (!parent.attr('data-appened-hover')) {
		        		parent.attr('data-appened-hover', 'true');
		        		parent.find('.pannel_title p').append(pen).append(trash);
	        		}
	        	}
	        },
	        /* Event recoit des éléments d'un autre container */
	        receive: function(event, ui){
	        	let parent = $(event.target).parents('[data-list-emails]');
	        	let idEmail = $(ui.item).data('email');

	        	if (parent.attr('data-section')) {
	        		var idCategorie = parent.data('section');
	        	} else {
					var idCategorie = 'NULL';
	        	}
	        	$.ajax({
					type: "POST",
					data: { idCategorie: idCategorie, idEmail: idEmail},
					url : "?module=user&action=emails", 
				});
	        },
	        /* Event lorqu'un item est déplacé dans un autre container */
	        remove: function(event, ui) {},
	        /* Event durant le mouvement */
	        sort: function(event, ui) {
	        },
	        /* Event à la création du sort */
	        start: function(event, ui){},
	        /* Event une fois que le sort est terminé */
	        stop: function(event, ui){
	        	let parent = $(ui.item).parents('[data-section]');
	        	if (parent.length == 1) {
	        		if (!parent.attr('data-appened-hover')) {
		        		parent.attr('data-appened-hover', 'true');
		        		parent.find('.pannel_title p').append(pen).append(trash);
	        		}
	        	}
	        },
	        /* Event au changement de l'ordre des éléments */
	        update: function(event, ui){
	        	// console.log(ui);
	        },
	    });
	}

	/* Active le formulaire */
	$(document).on('click', '#newCatFlipper', function() {
		$('#saveCatFlipper').removeAttr('data-appened');
		$('.flipper').addClass('active');
	});

	/* Ferme le formulaire */
	$(document).on('click', '#closedFlipper', function() {	
		$('.flipper').removeClass('active');
		$('#inputCatFlipper').val('');
	});

	/* Active le sortable */
	sortableEmailsList();

	/* Création d'une catégorie */
	$(document).on('click', '#saveCatFlipper', function(e) {
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');	
			e.preventDefault();

			var nbCategorie = $('[data-section]').length;

			if ($('#inputCatFlipper').val() != '') {
				var catName = $('#inputCatFlipper').val();
			} else {
				var catLength = $('[data-section]').length + 1;
				var catName = 'Catégorie '+catLength;
			}

			$.ajax({
				type: "POST",
				data: { catName: catName },
				url : "?module=user&action=emails", 
				success : function(data) {

					let cloneList = $('[data-list-emails]').last().clone();
					cloneList.find('li').remove();
					cloneList.attr('data-section', data);

					if (nbCategorie == 0) {
						cloneList.attr('data-allow', 1);
						cloneList.find('.pannel_title').html(titleListEmail);
					}
					
					cloneList.find('.title_row').html(catName)
					let h = $('[data-list-emails]').last().css('height');
					cloneList.css('height', '0px');

					cloneList.insertBefore('#pannelAddSection');

					$('.container_emails').animate({
			       		scrollTop: $('#newCatFlipper').offset().top
			    	}, 1000);
			    	$('[data-list-emails]').last().animate({
						height: h,
					},1000);

					sortableEmailsList();
				}
			});

			$('#closedFlipper').trigger('click');
		}

		return false;
	});

	/* Affiche le toolbox */
	$(document).on('mouseenter', '.email', function(e){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			e.preventDefault();
			$(this).children('[data-toolbox]').html('<i id="deleteBuilder" class="action_toolbox material-icons">delete_forever</i>'+
			'<i id="redirectBuilder" class="action_toolbox material-icons">create</i>'+
			'<i id="duplicateBuilder" class="action_toolbox material-icons">content_copy</i>').addClass('active');
		}
	});

	/* Cache le toolbox */
	$(document).on('mouseleave', '.email', function(e){
		if ($(this).attr('data-appened')) {
			$(this).removeAttr('data-appened');
			$(this).children('[data-toolbox]').removeClass('active').html('');
		}
	});

	/* Récupère l'id de l'email */
	function getEmailInfo(element) {
		var idEmail = $(element).parents('li').data('email');
		return idEmail;
	}

	/* Redirection vers l'email builder */
	$(document).on('click', '#redirectBuilder', function(){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			window.location.href = '?module=user&action=email_builder&id='+idEmail(this)+'';
		}
	});

	/* Ouverture de suppression d'un email */
	$(document).on('click', '#deleteBuilder', function(){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			let parent = $(this).parents('li');
			let emailID = parent.data('email');

			let popup = $('#deleteEmailConfirmation');
			popup.find('button').removeAttr('data-appened');

			popup.find('[data-delete-forever]').attr('id', emailID);
			popup.find('[data-delete-archive]').attr('id', emailID);
			popup.addClass('active');

			hidePopup(popup);
		}
	});

	/* Suppression vers archive d'un email */
	$(document).on('click', '[data-delete-archive]', function(){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');

			let emailID = $(this).attr('id');

			$.ajax({
				type: "POST",
				data: { archive: emailID },
				url : "?module=user&action=emails", 
				success : function(data) {
					block = $('[data-email="'+emailID+'"]');
					block.animate({
						'width': '0px',
						'height': '0px',
						'opacity': '0'},
						500, function() {
						block.remove();
						}
					);
				}
			});
		}
	});

	/* Suppression définitive d'un email */
	$(document).on('click', '[data-delete-forever]', function(){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');

			let emailID = $(this).attr('id');

			$.ajax({
				type: "POST",
				data: { trash: emailID },
				url : "?module=user&action=emails", 
				success : function(data) {
					block = $('[data-email="'+emailID+'"]');
					block.animate({
						'width': '0px',
						'height': '0px',
						'opacity': '0'},
						500, function() {
						block.remove();
						}
					);
				}
			});
		}
	});

	/* Ouverture de suppression d'une catégorie */
	$(document).on('click', '[data-delete-section]', function(){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			let parent = $(this).parents('[data-list-emails]');
			let catID = parent.attr('data-section');
						
			let rowEmail = parent.find('ul');
			let nbEmail = rowEmail.children('li').length;

			if (nbEmail == 0) {
				$.ajax({
					type: "POST",
					data: { idCategorie: catID },
					url : "?module=user&action=emails", 
					success : function(data) {
						container = $('[data-section="'+catID+'"]');
						container.animate({
							'height': '0px',
							'padding-top': '0px',
							'padding-bottom': '0px',
							'opacity': '0'},
							1000, function() {
							container.remove();
							}
						);
					}
				});
			} else {
				let popup = $('#deleteCatConfirmation');
				popup.find('button').attr('id', catID);
				popup.addClass('active');

				hidePopup(popup);
			}
		}
	});

	/* Suppression d'une catégorie */
	$(document).on('click', '#deleteCatConfirmation button', function(){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');

			if ($(this).attr('id')) {
				var catID = $(this).attr('id');

				$.ajax({
					type: "POST",
					data: { idCategorie: catID },
					url : "?module=user&action=emails", 
					success : function(data) {
						container = $('[data-section="'+catID+'"]');
						container.animate({
							'height': '0px',
							'padding-top': '0px',
							'padding-bottom': '0px',
							'opacity': '0'},
							1000, function() {
							container.remove();
							}
						);
					}
				});
				$(this).removeAttr('id data-appened');
			}
		}
	});

	/*----------  Emails & Template modifications de titre  ----------*/
	
	/* Affiche le petit crayon d'edition */
	$(document).on('mouseenter', '[data-list-emails], [data-list-templates]', function() {
		if (!$(this).attr('data-appened-hover')) {
			if ($(this).data('allow') != '0') {
				$('[data-appened-hover]').removeAttr('data-appened-hover');
				$(this).attr('data-appened-hover', 'true');
				if (!clicOnPen) {
					let title = $(this).find('.title_row');
					title.parent('p').append(pen);

					if ($(this).is('[data-list-emails]')) {
						title.parent('p').append(trash);
					}
				}
			}
		}
	});

	/* Cache le petit crayon d'edition */
	$(document).on('mouseleave', '[data-list-emails], [data-list-templates]', function(){
		if (!clicOnPen) {
			$(this)
			.removeAttr('data-appened-hover')
			.find('[data-editable-title]')
			.remove();

			if ($(this).is('[data-list-emails]')) {
				$(this).find('[data-delete-section]').remove();
			}
		}
	});

	/* Active l'édition d'un titre */
	$(document).on('click', '[data-editable-title]', function(e) {
		if (!clicOnPen) {
			if (!$(this).attr('data-appened')) {
				e.preventDefault();
				e.stopPropagation();
				if ($(this).parents('[data-list-emails]').length == 1) {
					emailPage = true;
					templatePage = false;
					$('[data-delete-section]').remove();
				} else if ($(this).parents('[data-list-templates]').length == 1) {
					emailPage = false;
					templatePage = true;
				}

				$(this).attr('data-appened', 'true');
				$(this).parents('[data-list-emails], [data-list-templates]').attr('data-appened-clic', 'true');
				title = $(this).prev('span');
				title
				.attr('contenteditable', 'true')
				.css('font-style', 'italic')
				.focus();

				contentTitle = $(title).text();
				$(this).replaceWith('<i class="material-icons" data-editable-title-done>done</i>');
				clicOnPen = true;
			}
		}
	});

	/* Vérifie le nombre de caractère de l'édition en cours */
	$(document).on('keydown', '.title_row', function(event) {
		if (event.keyCode == 13) {
			event.preventDefault();
			$('body').trigger("click");
		}
		if (title.text().length > 50 && event.keyCode != 8) {
			return false;
		}
	});

	/* Sauvegarde d'un titre */
	function updateTitle(title) {
		title
		.attr('contenteditable', 'false')
		.css('font-style', 'normal');

		if (title.text().length == 0 || title.text() == "") {
			title.html(contentTitle);
		} else {
			titleText = title.text();
			title.html(titleText);
		} 
		
		title = title.text();
		
		if (templatePage) {
			idTemplate = $('[data-appened-clic]').data('template');
			$.ajax({
				type: "POST",
				data: { template_title: title, idTemplate: idTemplate},
				url : "?module=user&action=template", 
			});
		} else if (emailPage) {
			idCategorie = $('[data-appened-clic]').data('section');
			$.ajax({
				type: "POST",
				data: { titleCategorie: title, idCategorie: idCategorie},
				url : "?module=user&action=emails",
			});
		}
		
		clicOnPen = false;
	}

	/* Sauvegarde l'edition de titre en cliquant sur le body */
	$(document).on('mousedown', 'body', function(e){
		if (clicOnPen) {
			if (emailPage) {
				var container = $(e.target).parents('[data-section]');
			} else if (templatePage) {
				var container = $(e.target).parents('[data-template]');
			}
			if (!$(e.target).hasClass('title_row')) {
				updateTitle(title);
				if ($(e.target).attr('data-section') || $(e.target).attr('data-template')) {
					if ($(e.target).attr('data-appened-clic')) {
						$('[data-editable-title-done]').replaceWith(pen);
						if ($(e.target).attr('data-section')) {
							$(e.target).find('.pannel_title p').append(trash);
						}
					}
					else {
						$('[data-editable-title-done]').remove();
					}
				}

				else if (container.length == 1) {
					if (container.attr('data-appened-clic')) {
						$('[data-editable-title-done]').replaceWith(pen);
						if (container.attr('data-section')) {
							container.find('.pannel_title p').append(trash);
						}
					}
					else {
						$('[data-editable-title-done]').remove();
						container.find('.pannel_title p').append(pen).append(trash);
					}
				}
				else {
					$('[data-appened-hover]').removeAttr('data-appened-hover');
					$('[data-editable-title-done]').remove();
				}
				$('[data-appened-clic]').removeAttr('data-appened-clic');
			}
		}
	});

	/*----------  Archive page  ----------*/

	function appearAction(boolean) {

		if (boolean == true) {
			$('[data-remove-archive]').addClass('active').removeAttr('disabled');
			$('[data-select-archive]').addClass('active').removeAttr('disabled');
		} else {
			$('[data-remove-archive]').removeClass('active').attr('disabled', 'disabled');
			$('[data-select-archive]').removeClass('active').attr('disabled', 'disabled');
		}
	}
	
	/* Selection d'une archive */
	$(document).on('click', '.archive:not(.active)', function(){
		if (!$(this).hasClass('active')) {
			$(this).addClass('active');
			
			appearAction(true);
		}
	});

	/* Désélection d'une archive */
	$(document).on('click', '.archive.active', function(){
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			
			var countSelected = $('.archive.active').length;

			if (countSelected == 0) {
				appearAction(false);
				$('[data-select-archive="allselect"]').addClass('active').removeAttr('disabled');
			}
		}
	});

	/* Selectionner tout */
	$(document).on('click', '[data-select-archive="allselect"]', function() {
		if ($('.archive:not(.active)').length != 0) {
			$('.archive').addClass('active');
			appearAction(true);
		}
	});

	/* Désélectionner tout */
	$(document).on('click', '[data-select-archive="deselect"]', function(){
		if (!$(this).attr('disabled')) {
			$(this).attr('disabled', 'disabled');
			
			$('[data-remove-archive]').removeClass('active').attr('disabled', 'disabled');
			$(this).removeClass('active').attr('disabled', 'disabled');
			$('.archive').removeClass('active');
		}
	});

	/* Suppression/Restauration d'archive */
	$(document).on('click', '[data-remove-archive]', function() {
		if ($('.archive.active').length != 0) {

			if ($(this).data('remove-archive') == 'delete') {
				
				$('.archive.active').each(function(){
					
					let archiveID = $(this).data('archive');
					
					$.ajax({
						type: "POST",
						data: { dArchiveID: archiveID },
						url : "?module=user&action=archives", 
						success : function(data) {
							let block = $('[data-archive="'+archiveID+'"]');
							block.animate({
								'width': '0px',
								'height': '0px',
								'opacity': '0'},
								500, function() {
									block.remove();
								}
							);
						}
					});
				});
			}
			else if ($(this).data('remove-archive') == 'restore') {
				$('.archive.active').each(function(){
					
					let archiveID = $(this).data('archive');
					
					$.ajax({
						type: "POST",
						data: { rArchiveID: archiveID },
						url : "?module=user&action=archives", 
						success : function(data) {
							let block = $('[data-archive="'+archiveID+'"]');
							block.animate({
								'width': '0px',
								'height': '0px',
								'opacity': '0'},
								500, function() {
									block.remove();
								}
							);
						}
					});
				});
			}
		}
	});

	/*----------  Order page  ----------*/



	$(".row_data_commande").click(function() {
		$(".popup-overlay, .popup-container").css({
			visibility:"visible",
			opacity:"1",
		}).show();
		if ($(this).find('span').hasClass('statut2')) {
			$(".commande").load("?module=admin&action=commandes&testTemplate="+$(this).attr("id"));
		}
		else {
			$(".commande").load("?module=admin&action=commandes&id="+$(this).attr("id"));
		}
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


	// Hide notif
	$(document).ready(function(){
	    $(".notif").delay(3000).hide("fast");
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
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
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
					                    url : "?module=admin&action=commandes"
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
										'<span class="label statut2">En attente de test</span>'
									);
									$('.commande').html(data);
								},
			                });
						});
						return false;
	               	});
	            }
	        });
			
			return false;
		}
	});

	$(document).on('click', '#testLaster', function(event) {
		event.preventDefault();
		$(".popup-overlay, .popup-container").css({
			visibility:"hidden",
			opacity:"0",
		});
	});

	$(document).on('click', '#cancelUpload', function(event) {
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			event.preventDefault();
			idOrder = $('[data-order]').attr('data-order');
			$.ajax({
	            type: "POST",
	            data: {cancelUpload: idOrder},
	            url : "?module=admin&action=commandes",
				complete(html) {
					$('.td_'+idOrder).html(
						'<span class="label statut1">Prise en charge</span>'
					);
				},
	        });
	        $(".popup-overlay, .popup-container").css({
				visibility:"hidden",
				opacity:"0",
			});
		}
	});

	$(document).on('click', '[data-try]', function(){
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			idOrder = $('[data-order]').attr('data-order');
			$.ajax({
	            type: "POST",
	            data: {testEmail: idOrder},
	            url : "?module=admin&action=commandes",
				complete(html) {
					window.location = "?module=user&action=email_builder&id="+html.responseText;
				},
	        });
		}
	});
/*=====  End of Commandes_page  ======*/
});