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
var flagAlert = false; // Etat de l'alerte de notification
var loaderHTML = '<div class="loader"><span></span></div>';
var publicKey = 'pk_test_jdtjz4b05ADqlx5k093fsmgK';
var StripeErr = {
	Card: 'Votre carte bancaire est invalide, le paiement a echoué',
	RateLimit: 'Trop de requêtes ont été envoyées à Stripe, le paiement a echoué',
	InvalidRequest: 'Paramètres invalide, le paiement a echoué',
	Authentication: 'Authentication à Stripe incorrecte, le paiement a echoué',
	ApiConnection: 'La communication avec Stripe a été perdue, le paiement a echoué',
	Base: 'Une erreur a s\'est produite, le paiement a echoué',
}

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

$.fn.hasAttr = function(name) {  
   return this.attr(name) !== undefined;
};

$(document).on('click', '.animation_blink', function(){
	$(this).removeClass('animation_blink');
});

$(document).on('click', '[data-btn-upgrade], [data-btn-subscribe]', function(event) {
	event.preventDefault();

	if ($(this).hasAttr('data-btn-subscribe')) {
		var booking_id = $(this).data('btn-subscribe');
		handler = stripe_subscription(booking_id, true);
	} else if ($(this).attr('data-btn-upgrade')) {
		var booking_id = $(this).data('btn-upgrade');
		handler = stripe_subscription(booking_id, false);
	}
	
	$.ajax({ 
	    type: 'GET', 
	    url: '?module=user&action=account', 
	    data: { booking_id: booking_id }, 
	    dataType: 'json',
	    success: function (data) {    
	    	handler.open({
				key: data.key,
				image: data.image,
				locale: data.locale,
				name: data.name,
			    zipCode: data.zipCode,
			    currency: data.currency,
			    amount: data.amount,
				description: data.description,
			});
	    },
	});

	$(window).on('popstate', function() {
		handler.close();
	});
});

function stripe_subscription(booking_id, action) {
	var handler = StripeCheckout.configure({
		key: publicKey,
		token: function(token) {
			var $metadata = '<input type="hidden" name="stripeToken" value="'+token.id+'"/>'+
			'<input type="hidden" name="stripeEmail" value="'+token.email+'"/>'+
			'<input type="hidden" name="stripePlan" value="'+booking_id+'" />';

			if (action == true) {
				$('[data-send-subscription="'+booking_id+'"]').prepend($metadata).submit();
			} else {
				$('[data-send-upgrade="'+booking_id+'"]').prepend($metadata).submit();
			}		
		}
	});
  	return handler;
}

function stripe_order() {
	var handler = StripeCheckout.configure({
		key: publicKey,
		token: function(token) {
			var $metadata = '<input type="hidden" name="stripeToken" value="'+token.id+'"/>'+
			'<input type="hidden" name="stripeEmail" value="'+token.email+'"/>';

			$('#formAddOrder').prepend($metadata);
			$('#formAddOrder').unbind('submit');
			document.getElementById('formAddOrder').submit();
		}
	});
  	return handler;
}

$(document).on('click', '#payAddOrder', function(event) {
	event.preventDefault();
	handler = stripe_order();
	$.ajax({ 
	    type: 'GET', 
	    url: '?module=user&action=template', 
	    data: { stripeOrder: true }, 
	    dataType: 'json',
	    success: function (data) { 
	    	handler.open({
				key: data.key,
				image: data.image,
				locale: data.locale,
				name: data.name,
			    zipCode: data.zipCode,
			    currency: data.currency,
			    amount: data.amount,
				description: data.description,
			});
	    },
	});

	$(window).on('popstate', function() {
		handler.close();
	});
});

// I : Activation/Desactivation de la sidebar 
function activateSidebar(btn) {
	$('#sidebar').toggleClass('active');
	$('#sidebar a').toggleClass('noactive');
	$('.others_links a').addClass('noactive');
	$('.large_container, .navigation').toggleClass('sidebar_opened');
	$(btn).toggleClass('active');
}

function displayNotif(text, type = false, timing = 4000) {
    document.getElementById('messageToUser').innerHTML = text;
    if (type = true) { c = "red"; } else { c = "green"; }
    document.getElementById('messageToUser').style.color = "red";
    document.getElementById('popupAlert').classList.add('active');
    setTimeout(function() {
         document.getElementById('popupAlert').classList.remove('active');
    }, timing);
}

if (document.getElementById('popupAlert').classList.contains('active')) {
	setTimeout(function() {
        document.getElementById('popupAlert').classList.remove('active');
    }, 4000);
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

function stripeSourceHandler(source) {
  // Insert the source ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeSource');
  hiddenInput.setAttribute('value', source.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
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

	/* Navigation dans le menu du profil */
	$(document).on('click', '[data-link-profil]', function(e){
		e.preventDefault();
		// $('.bg_field').removeClass('active');	
		// $('.info_accordeon').removeClass('active').css('height', '0px');
		$('.link_block').removeClass('active');
		$(this).parent().addClass('active');
		let menu = $(this).data('link-profil');
		$('[data-task]').hide();
		$('[data-task="'+menu+'"]').show();
	});

	/* Clic sur les paramètres de compte */
	$(document).on('click', "[data-info]", function(e) {
		e.preventDefault();
		if (!flagAdd) {
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
		}
	});

	/* Compte le nombre de chaque paramètres de compte */
	function countLi(id) {
		let list = '#'+id+'_list';
		let length = $(list+' li').length - 1;
		$('[data-count="'+id+'"]').html(length);
	}

	var role, inputHTML, saveHTML, cancelHTML, deleteHTML, row, rowAccountAdd, accordeon, x, h;

	function htmlAccount(input, data) {
		role = $(input).data(data);
		accordeon = $('#'+role);
		paramRow = $(input).parents('li');
		value = paramRow.find('[data-input]').val();
		saveHTML = '<input type="submit" value="Sauvegarder" data-save="'+role+'"/>';
		cancelHTML = '<input type="submit" value="Annuler" data-cancel="'+role+'"/>';
		deleteHTML = '<input type="submit" value="Supprimer" data-delete="'+role+'"/>';
		modifHTML = '<a href="#" title="" data-modif="'+role+'">Modifier</a>';
		h = parseFloat(accordeon.css('height'));
		x = parseFloat(paramRow.css('height'));
		if (role == 'password') {
			inputHTML = '<input type="password" data-input placeholder="**********"/>';
		};
		if (role == 'user') {
			inputHTML = '<input type="email" data-input placeholder="monemail@societe.com" />';
			rowAccountAdd = '<li><form class="row row-hori-between nowrap form-account" action=""><p>'+inputHTML+'</p><p>'+saveHTML+deleteHTML+'</p></form></li>'
		}
	}

	$(document).on('click', '[data-modif]', function(e) {
		e.preventDefault();
		htmlAccount(this, 'modif');
		paramRow.find('p:first-child').html(inputHTML);
		$(this).parent('p').html(saveHTML+cancelHTML);
	});

	$(document).on('click', '[data-cancel]', function(e) {
		e.preventDefault();
		htmlAccount(this, 'cancel');
		if (role == 'password') {
			paramRow.find('p:first-child').html("**********");
		}
		$(this).parent('p').html(modifHTML);
	});

	/* Active l'ajout d'un paramètre de compte */
	var flagAdd = false; // Etat du bouton ajout
	$(document).on('click', '[data-add]', function(e){
		e.preventDefault();
		if (!flagAdd) {
			flagAdd = true;
			$(this).addClass('desactivate');
			htmlAccount(this, 'add');
			accordeon.css('height',  h + x +'px');
			$(rowAccountAdd).insertBefore($(this).parents('li'));
		}
	});

	/* Active la sauvegarde d'un paramètre de compte */
	$(document).on('click', '[data-save]', function(e) {
		e.preventDefault();
		htmlAccount(this, 'save');
		
		if (role == 'user') {

			if (value == '') {
				displayNotif('Vous devez renseigner un email');
				return false;
			}

			if (!value.match( /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i ) ) {
				displayNotif('Veuillez respecter le format requis', false);
				return false;
			}

			$.ajax({
				type: "POST",
				data: { account: value },
				url : "?module=user&action=account", 
				success : function(respons) {
				  	if (respons.error) {
						displayNotif(respons[0], false);
						return false;
					}
					paramRow.find('p:first-child').html(value);
					$('[data-save]').parent('p').html(deleteHTML);
					$('.desactivate').removeClass('desactivate');
					accordeon.css('height',  h + x +'px');
					countLi(role);
					displayNotif('Un email a été envoyé à l\'utilisateur', true);
					flagAdd = false;
				}
			});
		}

		if (role == 'password') {
			if (value == '') {
				displayNotif('Vous devez renseigner un mot de passe', false);
				return false;
			}
			$.ajax({
				type: "POST",
				data: { password: value },
				url : "?module=user&action=account", 
				success : function(respons) {
					if (respons.error == true) {
						displayNotif('Une erreur est survenue', false);
						return false;
					}
				}
			});
			paramRow.find('p:first-child').html('***********');
			$('[data-save]').parent('p').html(modifHTML);
			displayNotif('Un email de confirmation vous a été envoyé', true);
			flagAdd = false;
		}
	});

	/* Active la suppression d'un paramètre de compte */
	$(document).on('click', '[data-delete]', function(e) {
		e.preventDefault();
		htmlAccount(this, 'delete');
		if (value == '') {

		} else {
			var id = paramRow.find('form').attr('id');
			$.ajax({
				type: "POST",
				data: { idAccount: id },
				url : "?module=user&action=account", 
				success : function(respons) {
					if (respons.error) {
						displayNotif(respons[0], false);
						return false;
					}
					displayNotif('Le compte utilisateur a bien été supprimé', true);
				}
			});
		}
		accordeon.css('height',  h - x +'px');
		$('[data-add]').removeClass('desactivate');
		paramRow.remove();
		countLi(role);
		flagAdd = false;
	});

	/* Empeche l'envoi du formulaire de paramètres de compte */
	$(document).on('submit', '.form-account', function(e) {
		e.preventDefault();
		return false;
	});

	/* Active la popup de détails d'abonnement */
	$(document).on('click', '[data-popup]', function(e){
		e.preventDefault();
		let data = this.getAttribute('data-popup');
		let popup = document.getElementById(data);	

		popup.classList.add('active');

		hidePopup($(popup));
	});

	/* Demande de suppression de l'abonnement */
	$(document).on('click', '#stopSubscription', function(e){
		e.preventDefault();
		$(this).parent('footer').animate( { 'height': '200px' }, 500,
			function() {
				$(this).html(
				'<p>Merci d\'indiquer votre mot de passe pour confirmer votre choix </p>'+
				'<p><input data-input-cancel-subscription type="password" name="userPassword"/></p>'+
				'<p><span class="errorMessage"></span></p>'+
				'<button id="cancelSubscription" class="button_default button_secondary">Je confirme</button>'
				);
			}
		);
	});

	/* Confirmation de suppression de l'abonnement */
	$(document).on('click', '#cancelSubscription', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var valuePassword = $('[data-input-cancel-subscription]').val();
		$(this).replaceWith(loaderHTML);
		$.ajax({
			type: "POST",
			data: { cancelSubscription: valuePassword },
			url : "?module=user&action=account", 
			success : function(respons) {
				console.log(respons);
				if (respons.error) {
					$('.errorMessage').html(respons[0]);
					$('.loader').replaceWith('<button id="cancelSubscription" class="button_default button_secondary">Je confirme</button>')
					return false;
				} else {
					window.location = "?module=user&action=account&cancel=ok";
				}
			},
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

	/* Active le formulaire de création de commande */
	$(document).on('click', '[data-popup-order]', function(){
		let popup = $('#templateOrder');

		popup.addClass('active');

		hidePopup(popup);
	});

	$(document).on('submit', '#formAddOrder', function(e) {
		e.preventDefault();
		$('#formAddOrder').addClass('noactive').removeClass('active');
		$('#formConfirmationAddOrder').addClass('active').removeClass('noactive');
	});

	$(document).on('submit', '#formConfirmationAddOrder', function(e) {
		e.preventDefault();
		$('#formAddOrder').unbind('submit');
		document.getElementById('formAddOrder').submit();
	});

	$(document).on('click', '#cancelAddOrder', function(e) {
		e.preventDefault();
		let popup = $('#templateOrder');
		hidePopup(popup);
		setTimeout(function(){
			$('#formAddOrder').addClass('active').removeClass('noactive');
			if (document.getElementById('formAddOrder')) {
				document.getElementById('formAddOrder').reset();
			}
			$('#formConfirmationAddOrder').addClass('noactive').removeClass('active');
		}, 800)
	});

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
		if (allowSelected && dateSelected) {
			$.ajax({
				type: "POST",
				data: { templates: allowSelected, orderby: dateSelected },
				url : "?module=user&action=template", 
				success : function(data) {
					$('.list_template ul').html(data);
				}
			});
		}
	});

	/* Création d'un email à partir d un template */
	$(document).on('click', '[data-creat-email]', function(e){
		e.preventDefault();
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			idTemplate = $(this).parents('li').data('template');
			$.ajax({
				type: "POST",
				data: { template_id: idTemplate },
				url : "?module=user&action=template", 
				success : function(data) {
					window.location = "?module=user&action=email_builder&id="+data;
				}
			});
		}
	});

	/*----------  Emails  ----------*/

	clicOnPen = false;

	function sortableEmailsList() {
	    $('.emails_list').sortable({
	    	connectWith: $('.emails_list'),
	        /* Curseur style quand mouvement en fonctionnement */
	        cursor: 'move',
	        /* Elements pouvant être déplacé */
	        items: "> li",
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
	        beforeStop: function(event, ui){},
	        /* Event au changement de l'ordre des éléments (durant le drag) */
	        change: function(event, ui){},
	        /* Event à la création du module (onready) */
	        create: function(event, ui){
	        	var notClassedList = $('[data-allow="0"] li').length;
	        	if (notClassedList == 0) {
	        		$('[data-allow="0"] ul').css('position', 'relative');
	        	}
	        },
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
					$('.empty_list_emails').parent('ul').css('position', 'static');
					$('.empty_list_emails').hide();
	        	}
	        	$.ajax({
					type: "POST",
					data: { idCategorie: idCategorie, idEmail: idEmail},
					url : "?module=user&action=emails", 
				});
				var notClassedList = $('[data-allow="0"] li').length;
	        	if (notClassedList == 0) {
	        		$('[data-allow="0"] ul').css('position', 'relative');
	        		$('.empty_list_emails').show();
	        	}
	        },
	        /* Event lorqu'un item est déplacé dans un autre container */
	        remove: function(event, ui) {},
	        /* Event durant le mouvement */
	        sort: function(event, ui) {},
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
	        update: function(event, ui){},
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

			/* Duplication d'un email */
			if (document.getElementById('duplicateBuilder')) {
				document.getElementById('duplicateBuilder').addEventListener('click', function(e) {
					var block = this.parentElement.parentElement;
					var idEmail = parseInt(block.getAttribute('data-email'));
					var rowEmail = block.parentElement;
					$.ajax({
						type: "POST",
						data: { idEmail: idEmail },
						url : "?module=user&action=emails", 
						success : function(data) {
							let folder = data;
							let idEmail = data.split('_')[0];
							let cloneEmail = $(block).clone();
							cloneEmail.removeAttr('data-appened');
							cloneEmail.find('[data-toolbox]').html('').removeClass('active');
							cloneEmail.attr('data-email', idEmail);

							src = cloneEmail.css('background').split('/');

							let newSrc = src[0]+'/'+src[1]+'/'+src[2]+'/'+folder+'/'+src[4];
							cloneEmail.css('background', newSrc);
							$(rowEmail).append(cloneEmail);
						}
					});
				});
			}
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
					success : function() {
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
							appearAction(false);
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
							appearAction(false);
						}
					});
				});
			}
		}
	});

	/*----------  Order page  ----------*/

	$(document).on('click', '[data-order]', function() {
		let popup = $('#orderPopup');
		popup.addClass('active');

		hidePopup(popup);

		$("#orderPopup .popup_container").load("?module=admin&action=commandes&id="+$(this).data("order"));
	});

	/* Show confirmation ==> update order */
	$(document).on('click', '#valideOrder', function (e) {
		e.preventDefault();
		$(this).parent('footer').animate({
			'min-height': '120px',
		}, 500, function(){
			$('#valideOrder').parent('footer').html(
			'<p>Confirmer et envoyer un email à l\'utilisateur ?</p>'+
			'<button id="confirmValideOrder" class="button_default button_secondary">Confirmer</button>'
			);
		});
	});

	/* Update confirmation post ==> Order supported */
	$(document).on('click', '#confirmValideOrder', function (e) {
		e.preventDefault();

		var idOrder = $(this).parent('footer').attr('id');

		$.ajax({
			type: "POST",
			data: { order: idOrder },
			url : "?module=admin&action=commandes", 
			success : function(data) {
				$('#confirmValideOrder').parent('footer').html(
					'<p>Prise en charge effectuée !'
				);

				$('#orderPopup').find('.statut').parent('p').html(
					'<span class="statut statut1">Prise en charge</span>'
				);

				$('[data-order="'+idOrder+'"]').find('.statut').parent('td').html(
					'<span class="statut statut1">Prise en charge</span>'
				);
			}
		});
	});

	/* Update confirmation post ==> Order finished */
	$(document).on('click', '#finishOrder', function(e) {
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			e.preventDefault();

			var idOrder = $(this).parent('footer').attr('id');

			$(this).parents('.popup_container').load("?module=admin&action=commandes&id_commande="+idOrder);
		}
	});

	$(document).on('click', '#previewUploadTemplate', function(e) {
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			e.preventDefault();
			 
	        var $form = $('#formPreviewTemplate');
	        var formdata = (window.FormData) ? new FormData($form[0]) : null;
	        var data = (formdata !== null) ? formdata : $form.serialize();
			var idOrder = $(this).parent('footer').attr('id');
			var dom = $('#DOM').val();
			var medias = $('#mco_template_mobile').val();

	        $.ajax({
	            url: "?module=admin&action=commandes",
	            type: "POST",
	            contentType: false,
	            processData: false,
	            dataType: 'json',
	            data: data,
	            complete: function (html) {
	                var newDom = dom.replace(new RegExp('images/', 'g'), html.responseText);
					$('#previewUploadTemplate').parent('footer').html(
						'<button id="valideUploadOrder" class="button_default button_secondary">Valider le template</button>'
					);
					$('#orderPopup header').hide();
					$('#orderPopup .content_block').html(newDom);

	               	$(document).on('click', '#valideUploadOrder', function(e) {
	               		e.preventDefault();
						
						var container = $('.popup_container .content_block');
						cheminImage = html.responseText;
						cheminThumbs = cheminImage.replace('images', 'thumbnails');
						html2canvas(container, {
							onrendered: function(canvas) {
								$.ajax({
				                    type: "POST",
				                    data: {thumbnail: canvas.toDataURL("image/png"), chemin: cheminThumbs },
				                    url : "?module=admin&action=commandes"
				                });
							}
						});


	               		$('#orderPopup [data-section]').each(function(){
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
							dom = $('#orderPopup .content_block').html();
						    $.ajax({
			                    type: "POST",
			                    data: {addToBdd: idOrder, DOM: dom, mco_template_mobile: medias, userId: idUser },
			                    url : "?module=admin&action=commandes",
								success: function(data) {
									$('[data-order="'+idOrder+'"]').find('.statut').parent('td').html(
										'<span class="statut statut2">En attente de test</span>'
									);
									$('#orderPopup .popup_container').html(data);
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

	$(document).on('click', '#cancelUpload', function(e) {
		e.preventDefault();
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			idOrder = $(this).parents('footer').attr('id');
			$.ajax({
	            type: "POST",
	            data: {cancelUpload: idOrder},
	            url : "?module=admin&action=commandes",
				complete(html) {
					$('[data-order="'+idOrder+'"]').find('.statut').parent('td').html(
						'<span class="statut statut1">Prise en charge</span>'
					);
				},
	        });
		}
	});

	$(document).on('click', '#testOrder', function(e){
		e.preventDefault();
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			idOrder = $(this).parent('footer').attr('id');
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

/*======================================
=            Template Admin            =
======================================*/

	/* Changement des selects */
	$(document).on('change', '[data-select-template]', function(e) {
		var templateUser;
		if ($(this).attr('id') == 'selectDisplayUser') {
			var user = JSON.parse($(this).val());
			if (user) { 
				$("#selectDisplayType").val('true');
				templateUser = user;
			}
		}

		if ($(this).attr('id') == 'selectDisplayType') {
			var type = JSON.parse($(this).val());
			if (!type) { 
				$("#selectDisplayUser").val('false'); 
				templateUser = 'all';
			} else {
				$("#selectDisplayUser").addClass('animation_blink');
			}
		}
		if (templateUser) {
			$.ajax({
				type: "GET",
				data: { selectTemplate: templateUser },
				url : "?module=admin&action=templates", 
				success : function(html) {
					$('.list_template ul').html(html);
				}
			});
		}
	});

	$(document).on('click', '[data-popup-template]', function(){
		let popup = $('#addTemplatePublic');
		popup.addClass('active');

		hidePopup(popup);
	});

	$(document).on('submit', '#formAddTemplate', function(e){
		e.preventDefault();
		if (!$(this).attr('data-appened')) {
			$(this).attr('data-appened', 'true');
			 
	        var $form = $('#formAddTemplate');
	        var formdata = (window.FormData) ? new FormData($form[0]) : null;
	        var data = (formdata !== null) ? formdata : $form.serialize();
			var dom = $('#templateDOM').val();
			var medias = $('#templateQuery').val();
			var title = $('#templateName').val();

	        $.ajax({
	            url: "?module=admin&action=templates",
	            type: "POST",
	            contentType: false,
	            processData: false,
	            dataType: 'json',
	            data: data,
	            complete: function (html) {
	              	var newDom = dom.replace(new RegExp('images/', 'g'), html.responseText+'/');
					$('#formAddTemplate footer').html(
						'<button id="validePreview" class="button_default button_secondary">Valider le template</button>'
					);
					$('#addTemplatePublic header').hide();
					$('#addTemplatePublic .content_block').html(newDom);
					
					$(document).on('click', '.content_block a', function(e){
						e.preventDefault();
					});

					$(document).on('click', '#validePreview', function(e){
						e.preventDefault();
						var container = $('#addTemplatePublic .content_block');
						cheminImage = html.responseText;
						html2canvas(container, {
							onrendered: function(canvas) {
								$.ajax({
				                    type: "POST",
				                    data: {thumbnail: canvas.toDataURL("image/png"), chemin: cheminImage, dom: dom, medias: medias, title: title},
				                    url : "?module=admin&action=templates",
				                    complete: function (html) {
				                    	var data = JSON.parse(html.responseText);
				                    	var templateID = data[1];
				                    	$('#addTemplatePublic [data-section]').each(function(){
											var id = Math.floor(Math.random() * 16777215).toString(16);
										    $(this).attr('data-section', id);
											var section = $('[data-section="'+id+'"]');
											cheminImage = data[0];
											cheminThumbs = cheminImage.replace('images', 'thumbnails');
											html2canvas(section, {
												onrendered: function(canvas) {
													$.ajax({
									                    type: "POST",
									                    data: {thumb: canvas.toDataURL("image/png"), nameThumb: id, chemin: cheminThumbs },
									                    url : "?module=admin&action=templates",
									                });
												}
											});
										}).promise().done(function () { 
											dom = $('#addTemplatePublic .content_block').html();
										    $.ajax({
							                    type: "POST",
							                    data: {templateID: templateID, DOM: dom},
							                    url : "?module=admin&action=templates",
												complete: function(html) {
													if (JSON.parse(html.responseText) === true) {
														displayNotif('Template public inséré !', true);
													} else {
														displayNotif('Une erreur est survenue', false);
													}
												},
							                });
										});
				                    }
				                });
							}
						});
					});
	            }
	        });
		}
	});

/*=====  End of Template Admin  ======*/
});