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
var stopSubHtml = '<p>Merci d\'indiquer votre mot de passe pour confirmer votre choix </p>'+
		'<p><input data-input-cancel-subscription type="password" name="userPassword"/></p>'+
		'<p><span class="errorMessage"></span></p>'+
		'<button id="cancelSubscription" class="button_default button_secondary">Je confirme</button>';
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

$(document).on('click', '[data-btn-upgrade], [data-btn-subscribe], [data-paymentdefaut]', function(event) {
	event.preventDefault();
	if ($(this).hasAttr('data-paymentdefaut')) {
		handler = updateCard();
		$.ajax({ 
			type: 'GET', 
			url: '?module=user&action=account', 
			data: {
				defautpayment : "true",
				booking_id: booking_id 
			}, 
			dataType: 'json',
			success: function (res) {
				handler.open({
					key: res.key,
					image: res.image,
					locale: res.locale,
					name: res.name,
					zipCode: res.zipCode,
					description: res.description,
					panelLabel :res.label,
				});
			},
			error: function(data){
			},
			fail: function(data){
			}
		});
	}
	else if ($(this).hasAttr('data-btn-subscribe')) {
		var booking_id = $(this).data('btn-subscribe');
		handler = stripe_subscription(booking_id, true);
		$.ajax({ 
			type: 'GET', 
			url: '?module=user&action=account', 
			data: { 
				subscribing : "true",
				booking_id: booking_id 
			}, 
			dataType: 'json',
			success: function (res) {
				handler.open({
					key: res.key,
					image: res.image,
					locale: res.locale,
					name: res.name,
					zipCode: res.zipCode,
					currency:res.currency,
					amount: res.amount,
					description: res.description
				});
			},
		});
	} else if ($(this).attr('data-btn-upgrade')) {
		var booking_id = $(this).data('btn-upgrade');
		$.ajax({
			type: 'GET', 
			url: '?module=user&action=account',
			data: { 
				update: "true",
				booking_id: booking_id
			}, 
			dataType: 'json',
			success: function(res){
				let proration = parseFloat(res['lines']['data'][0]['amount']) / 100;
				let actualPlan = parseFloat(res['lines']['data'][1]['amount']) / 100;
				let newPlan = parseFloat(res['lines']['data'][2]['amount']) / 100;
				let prorationDate = res['subscription_proration_date'];
				let prorationActualPlan = (proration/newPlan * actualPlan).toPrecision(4);
				let nextBill = (proration - prorationActualPlan + newPlan).toPrecision(4);

				document.getElementById('proration').textContent = proration;
				document.getElementById('actualPlan').textContent = prorationActualPlan;
				document.getElementById('newPlan').textContent = newPlan;
				document.getElementById('nextBill').textContent = nextBill;
				document.getElementById('booking_id').value = booking_id;
				document.getElementById('subscription_proration_date').value = prorationDate;

				let popup = document.getElementById('upgradeSubscription');
				popup.classList.add('active');
				hidePopup($(popup));
			}
		});
	}

	$(window).on('popstate', function() {
		handler.close();
	});
});

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

function stripe_subscription(booking_id, action) {
	var handler = StripeCheckout.configure({
		key: publicKey,
		token: function(token) {
			var $metadata = '<input type="hidden" name="stripeToken" value="'+token.id+'"/>'+
			'<input type="hidden" name="stripeEmail" value="'+token.email+'"/>'+
			'<input type="hidden" name="stripePlan" value="'+booking_id+'" />';
	
			$('[data-send-subscription="'+booking_id+'"]').prepend($metadata).submit();	
		}
	});
  	return handler;
}
function updateCard() {
	var handler = StripeCheckout.configure({
		key: publicKey,
		token: function(token) {
			var $metadata = '<input type="hidden" name="stripeToken" value="'+token.id+'"/>';
			$('[data-update-card=""').prepend($metadata).submit();
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
				metadata:  data.metadata
			});
	    },
	});

	$(window).on('popstate', function() {
		handler.close();
	});
});

function hidePopup(popup) {
	$(document).on('click', '.popup_background, [data-close-popup]', function(){
		popup.removeClass('active');		
	});
}

function displayNotif(text, type = false, timing = 4000) {
    document.getElementById('messageToUser').innerHTML = text;
    if (type == false) { c = "red"; } else { c = "green"; }
    document.getElementById('messageToUser').style.color = c;
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

function parents(node) {
   	let current = node, list = [];
   	while(current.parentNode != null && current.parentNode != document.documentElement) {
     	list.push(current.parentNode);
     	current = current.parentNode;
   	}
    return list;
}

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

var checkHandle = function(event) {
	event.preventDefault();
    if (!event.handled) {
        event.handled = true
        return event.handled;
    }
}

function formatParams( params ){
  return Object
        .keys(params)
        .map(function(key){
          return key+"="+encodeURIComponent(params[key])
        })
        .join("&")
}

/*----------  Actions  ----------*/

// Démarrage des modules avec turbolinks.
document.addEventListener("turbolinks:load", function(e) {
	if (checkHandle(e)) {

		if (getUrlParameter('module') == 'user') {
			actionUrl = getUrlParameter('action');
			document.querySelectorAll('.important_links a').forEach( function(element, index) {
				element.classList.remove('active');
			});
			if (document.querySelector('.important_links a[href="?module=user&action='+actionUrl+'"]')) {
				document.querySelector('.important_links a[href="?module=user&action='+actionUrl+'"]').classList.add('active');
			}
		}

		document.querySelectorAll('.popup_background').forEach( function(element, index) {
			element.addEventListener('click', function(e) {
				this.parentElement.classList.remove('active');
			}, false);
		});

		function activateSidebar(btn) {
			document.getElementById('sidebar').classList.toggle("active");
			document.querySelectorAll('.important_links a').forEach( function(element, index) {
				element.classList.toggle('noactive');
			});
			document.querySelectorAll('.others_links a').forEach( function(element, index) {
				element.classList.add('noactive');
			});
			document.querySelector('.large_container').classList.toggle('sidebar_opened');
			document.querySelector('.navigation').classList.toggle('sidebar_opened');
			btn.classList.toggle('active');
		}

		document.getElementById('menu').addEventListener('click', function(e) {
			if (checkHandle(e)) {
				activateSidebar(this);
			}
		}, false);

		document.querySelector('#searchForm input').addEventListener('focus', function(e) {
			document.getElementById('searchForm').classList.add('focus');
		}, false);

		document.querySelector('#searchForm input').addEventListener('blur', function(e) {
			document.getElementById('searchForm').classList.remove('focus');
			this.value = '';
		}, false);

		document.getElementById('searchForm').addEventListener('submit', function(e) {
			e.preventDefault();
			return false;
		}, false);

		document.querySelectorAll('[data-link]').forEach( function(element, index) {
			element.addEventListener('click', function(e){
				var url = this.getAttribute('data-link');
				Turbolinks.visit(url);
			}, false);
		});

		document.querySelectorAll('[data-popup-preview]').forEach( function(element, index) {
			element.addEventListener('click', function(e) {
				if (this.nodeName.toLowerCase() == 'li') {
					var elementLi = this;
				} else {
					var elementLi = parents(this)[1];
				}
				
				let elementLiId = elementLi.getAttribute('data-template');
				let elementLiAllow = elementLi.getAttribute('data-allow');
				let popupPreview = document.getElementById('templatePreview');

				var url = '?module=user&action=template';
				var params = {
				  id: elementLiId, 
				  allow: elementLiAllow,
				}
				var http = new XMLHttpRequest();
				http.open("GET", url+"&"+formatParams(params), true);
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.onreadystatechange = function() {
	        		if (http.readyState == 4 && http.status == 200) {
	        			popupPreview.children[1].innerHTML = http.response;
	        		}
	        	}
	        	http.send(null);
				popupPreview.classList.add('active');

			}, false);
		});

		var menuProfil = document.querySelectorAll('[data-link-profil]');
		menuProfil.forEach( function(element, index) {
			element.addEventListener('click', function(e) {
				e.preventDefault();
				if (checkHandle(e)) {
					document.querySelectorAll('.link_block').forEach( function(el, index) {
						el.classList.remove('active');
					});
					element.parentElement.classList.add('active');
					document.querySelectorAll('[data-task]').forEach( function(el, index) {
						el.style.display = 'none';
					});

					let id = element.getAttribute('data-link-profil');
					document.querySelector('[data-task="'+id+'"]').style.display = 'block';
				}
			}, false);
		});
		
		document.querySelectorAll('[data-info]').forEach( function(element, index) {
			element.addEventListener('click', function(e) {
				if (checkHandle(e)) {
					let id = this.getAttribute('data-info');
					let accordeon = document.getElementById(id);

					if (accordeon.classList.contains('active')) {
						document.querySelector('[data-field="'+id+'"]').classList.remove('active');
						accordeon.style.height = "0px";
						accordeon.classList.remove('active');
					}

					else {
						document.querySelectorAll('.bg_field').forEach( function(element, index) {
							element.classList.remove('active');
						});
						document.querySelector('[data-field="'+id+'"]').classList.add('active');
						document.querySelectorAll('.info_accordeon').forEach( function(element, index) {
							element.classList.remove('active');
							element.style.height = '0px';
						});
						var h = document.querySelector('#'+id+' > div').offsetHeight;
						accordeon.style.height = h+'px';
						accordeon.classList.add('active');
					}
				}
			}, false);
		});

		function countLi(id) {
			let lenght = document.getElementById(id+'_list').children.length;
			document.querySelector('[data-count="'+id+'"]').textContent = lenght - 1;
		}

		var role, inputHTML, apiSelect, saveHTML, cancelHTML, deleteHTML, row, rowAccountAdd, rowAddApi, accordeon, x, h;

		function htmlAccount(input, data) {
			role = input.getAttribute('data-'+data);
			accordeon = document.getElementById(role);
			paramRow = input.parentElement.parentElement;
			value = paramRow.firstElementChild.textContent;

			saveHTML = '<input type="submit" value="Sauvegarder" data-save="'+role+'"/>';
			cancelHTML = '<input type="submit" value="Annuler" data-cancel="'+role+'"/>';
			deleteHTML = '<input type="submit" value="Supprimer" data-delete="'+role+'"/>';
			modifHTML = '<a href="#" title="" data-modif="'+role+'">Modifier</a>';

			h = parseFloat(accordeon.offsetHeight);
			x = parseFloat(paramRow.offsetHeight);
			if (role == 'adresse_factu') {
				inputHTML = '<input type="text" data-input placeholder="28, rue du chemin vert, 75011 PARIS"/>';
			}
			if (role == 'password') {
				inputHTML = '<input type="password" data-input placeholder="**********"/>';
			}
			if (role == 'user') {
				inputHTML = '<input type="email" data-input placeholder="monemail@societe.com" />';
				rowAccountAdd = '<li><form class="row row-hori-between nowrap form-account" action=""><p>'+inputHTML+'</p><p>'+saveHTML+deleteHTML+'</p></form></li>';
			}
			if(role == 'api'){
				apiSelect = '<select id="api-select"><option value="" disable>Selectionner un routeur</option>';
				for (var i = 0; i < Object.keys(apiList).length; i++) {
					apiSelect = apiSelect + '<option value="'+Object.keys(apiList)[i]+'">'+Object.keys(apiList)[i]+'</option>';
				}
				apiSelect = apiSelect + '</select>';
				rowAddApi = '<li><form class="row row-hori-between nowrap form-account" action=""><p>'+apiSelect+'</p><p>'+saveHTML+deleteHTML+'</p></form></li>';
			}
		}

		function modifDataUser() {
			document.querySelectorAll('[data-modif]').forEach( function(element, index) {
				element.addEventListener('click', function(e) {
					e.preventDefault();
					htmlAccount(this, 'modif');
					paramRow.firstElementChild.innerHTML = inputHTML;
					this.parentElement.innerHTML = saveHTML+cancelHTML;
					saveDataUser();
					cancelActionUser();
				}, false);
			});
		}
		modifDataUser();

		function cancelActionUser() {
			document.querySelectorAll('[data-cancel]').forEach( function(element, index) {
				element.addEventListener('click', function(e) {
					e.preventDefault();
					htmlAccount(this, 'cancel');
					if (role == 'password') {
						paramRow.firstElementChild.textContent = "*******";
					}
					this.parentElement.innerHTML = modifHTML;
					modifDataUser();
				}, false);
			});
		}

		var flagAddUser = false;
		document.querySelectorAll('[data-add=user]').forEach( function(element, index) {
			element.addEventListener('click', function(e) {
				e.preventDefault();
				if (checkHandle(e) && !flagAddUser) {
					flagAddUser = true;
					htmlAccount(this, 'add');
					accordeon.style.height = h + x +'px';
					var div = document.createElement('div');
					div.innerHTML = rowAccountAdd;
					var li = this.parentElement.parentElement;
					li.parentNode.insertBefore(div.firstElementChild, li);
					deleteDataUser();
					saveDataUser();
				}
			}, false)
		});

		var flagAddApi = false;
		document.querySelectorAll('[data-add=api]').forEach( function(element, index) {
			element.addEventListener('click', function(e) {
				e.preventDefault();
				if (checkHandle(e) && !flagAddApi) {
					flagAddApi = true;
					htmlAccount(this, 'add');
					accordeon.style.height = h + x +'px';
					var div = document.createElement('div');
					div.innerHTML = rowAddApi;
					var li = this.parentElement.parentElement;
					li.parentNode.insertBefore(div.firstElementChild, li);
					addChangeSelect();
					deleteDataApi();
					saveDataUser();
				}
			},false);
		});
		function deleteDataUser() {
			document.querySelectorAll('[data-delete=user]').forEach( function(element, index) {
				element.addEventListener('click', function(e){
					e.preventDefault();
					var self = this;
					var id = parents(this)[1].getAttribute('id');
					var url = window.location.href;
					var params = {
					  idAccount: id,
					}
					var http = new XMLHttpRequest();
					http.open("POST", url, true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					http.responseType = 'json';
					http.onreadystatechange = function() {
		        		if (http.readyState == 4 && http.status == 200) {
		        			if (http.response != null) {
								displayNotif(http.response[0], false);
								return false;
							} else {
								displayNotif('Le compte utilisateur a bien été supprimé', true);
								h = parseFloat(parents(self)[5].offsetHeight);
								x = parseFloat(parents(self)[2].offsetHeight);
					   			parents(self)[5].style.height =  h - x +'px';
								parents(self)[2].remove();
								flagAdd = false;
								$("[data-count=user").html(
									parseFloat($("[data-count=user").html()) - 1
								);
							}
		        		}
		        	}
		        	http.send(formatParams(params));
				}, false);
			});
		}
		deleteDataUser();

		function addChangeSelect(){
			document.getElementById('api-select').addEventListener("change",function(){
				var componentsApi = document.getElementsByClassName('componentsApi');
				for (i = 0; i < componentsApi.length; i++) { 
					componentsApi[i].remove();
				}
				let apiSelected = this.value;
				if(apiSelected){
					let html ="";
					let componentsNeeded = apiList[apiSelected];
					for (var i = 0; i < componentsNeeded.length; i++) {
						html = html + '<input type="text" data-input="'+componentsNeeded[i]+'" placeholder="Insert your '+componentsNeeded[i].replace("_"," ")+'">';
					}
					let pContainer = document.createElement('p');
					pContainer.innerHTML = html;
					pContainer.className = 'componentsApi';
					var selecter = document.getElementById('api-select').parentNode.parentNode;
					selecter.insertBefore(pContainer,selecter.childNodes[1]);
				}
			});
		} 

		function deleteDataApi() {
			document.querySelectorAll('[data-delete=api]').forEach( function(element, index) {
				element.addEventListener('click', function(e){
					e.preventDefault();
					var self = this;
					var id = parents(this)[1].getAttribute('id');
					var url = window.location.href;
					var params = {
						idApi: id,
					}
					var http = new XMLHttpRequest();
					http.open("POST", url, true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					http.responseType = 'json';
					http.onreadystatechange = function() {
		        		if (http.readyState == 4 && http.status == 200) {
		        			if (http.response != null) {
								displayNotif(http.response[0], false);
								return false;
							} else {
								displayNotif('Le compte API a bien été supprimé', true);
								h = parseFloat(parents(self)[5].offsetHeight);
								x = parseFloat(parents(self)[2].offsetHeight);
					   			parents(self)[5].style.height =  h - x +'px';
								parents(self)[2].remove();
								flagAdd = false;
								countLi('api');
							}
		        		}
		        	}
		        	http.send(formatParams(params));
				}, false);
			});
		}
		deleteDataApi();

		function saveDataUser() {
			document.querySelectorAll('[data-save]').forEach( function(element, index) {
				element.addEventListener('click', function(e) {
					var self = this;
					e.preventDefault();
					role = this.getAttribute('data-save');
					if(role == 'adresse_factu'){
						adresse_factu = document.getElementById('adresse_factu');
						input = adresse_factu.querySelectorAll('input')[0];
						if (input.value == '') {
							displayNotif('Vous devez renseigner une adresse', false);
							return false;
						}
						else{
							var url = window.location.href;
							var params = {
							  adress: input.value,
							}
							var http = new XMLHttpRequest();
							http.open("POST", url, true);
							http.responseType = 'json';
							http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							http.onreadystatechange = function() {
				        		if (http.readyState == 4 && http.status == 200) {
									let data = http.response;
				        			if (http.response != null) {
										displayNotif(data[0], false);
										return false;
									} else {
										displayNotif('Votre adresse a été mise à jour', true);
									}
				        		}
				        	}
				        	http.send(formatParams(params));
						}
					}
					if(role == 'password'){
						password_list = document.getElementById('password_list');
						input = password_list.querySelectorAll('input[type=password]')[0];
						if (input.value == '') {
							displayNotif('Vous devez renseigner un mot de passe', false);
							return false;
						}
						else{
							var url = window.location.href;
							var params = {
							  password: input.value,
							}
							var http = new XMLHttpRequest();
							http.open("POST", url, true);
							http.responseType = 'json';
							http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							http.onreadystatechange = function() {
				        		if (http.readyState == 4 && http.status == 200) {
									let data = http.response;
				        			if (http.response != null) {
										displayNotif(data[0], false);
										return false;
									} else {
										displayNotif('Votre mot de passe a été mis à jour', true);
									}
				        		}
				        	}
				        	http.send(formatParams(params));
						}
					}
					if (role == 'user') {
						input = this.parentElement.previousSibling.firstElementChild;
						if (input.value == '') {
							displayNotif('Vous devez renseigner un email', false);
							return false;
						} else if (!input.value.match( /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i ) ) {
							displayNotif('Veuillez respecter le format requis', false);
							return false;
						} else {
							var url = window.location.href;
							var params = {
							  account: input.value,
							}
							var http = new XMLHttpRequest();
							http.open("POST", url, true);
							http.responseType = 'json';
							http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							http.onreadystatechange = function() {
				        		if (http.readyState == 4 && http.status == 200) {
									let data = http.response;
				        			if (http.response != null) {
										displayNotif(data[0], false);
										return false;
									} else {
										input.parentElement.innerHTML = input.value;
							   			self.parentElement.innerHTML = '<input type="submit" value="Supprimer" data-delete="user"/>';
							   			countLi('user');
							   			displayNotif('Un email a été envoyé à l\'utilisateur', true);
							   			flagAdd = false;
									}
				        		}
				        	}
				        	http.send(formatParams(params));
						}
					}
					if(role ==='api'){
						e.preventDefault();
						inputs = this.parentElement.previousSibling.childNodes;
						var data = new Array();
						inputs.forEach(function(element,index){
							let val = element.value;
							let key = element.getAttribute('data-input');
							if(!val){
								displayNotif('Vous devez renseigner tous les champs', false);
								return false;
							}
							else{
								data[key] = val
							}
						});
						if(Object.keys(data).length === inputs.length){
							var select = this.parentElement.previousSibling.previousSibling.firstElementChild;
							data['router_name'] = select.value;
							data['add_api'] = true;
							var url = window.location.href;
							var params = data;
							var http = new XMLHttpRequest();
							$.ajax({
								type: "POST",
								url: window.location.pathname+'/?module=user&action=test-api',
								data:{
									'api-test':true,
									'api-key': params['api_key'],
									'api-secret': params['api_secret'],
									'api-name':params['router_name']
								},
								dataType: "json",
								success: function(msg){
									if(!msg.code){
										http.open("POST", url, true);
										http.responseType = 'json';
										http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
										http.onreadystatechange = function() {
											if (http.readyState == 4 && http.status == 200) {
												let data = http.response;
												if (http.response != null) {
													displayNotif(data[0], false);
													return false;
												} else {
													inputs.forEach(function(element,index){
														element.parentElement.innerHTML = element.value;
													});
													select.parentElement.innerHTML = select.value;
													   self.parentElement.innerHTML = '<input type="submit" value="Supprimer" data-delete="api"/>';
													   countLi('api');
													   displayNotif("L'api a bien été ajouté", true);
													   flagAdd = false;
												}
											}
										}
										http.send(formatParams(params));
									}
									else{
										displayNotif(msg.code +' : '+ msg.message, false);
										return false;
									}
								},
								fail : function(msg){
									displayNotif("Une erreur s'est produite", false);
									return false;
								},
								error:function(msg){
									displayNotif(msg.responseText, false);
									return false;
								}
							});
						}
						else{
							displayNotif('Vous devez renseigner tous les champs', false);
							return false;
						}
					}
				}, false);
			});
		}
		saveDataUser();
		

		/* Téléchargement de la facture */
		$(document).on('click', '[data-facture]', function(e) {
			let lines = $(this).parents()[1];
			let values = lines.getElementsByTagName("td")
			let id_facture = encodeURI(values[0].innerHTML);
			let date_facture = encodeURI(values[3].innerHTML);
			let societe =encodeURI( $(this).data("facture"));
			let adress =encodeURI( $(this).data("adress"));
			let designation = encodeURI(values[1].innerHTML);
			let price = encodeURI(values[2].innerHTML.replace('€',''))
			var redirectWindow = window.open(window.location.pathname+'/?module=user&action=factures&id_facture='+id_facture+'&date_facture='+date_facture+'&societe='+societe+'&designation='+designation+'&price='+price+'&adress='+adress, '_blank');
    		redirectWindow.location;
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

		/* Active la popup de détails d'abonnement par la pricing table*/
		$(document).on('click', '#stopSubscriptionFromPricingTable', function(e){
			e.preventDefault();
			let data = this.getAttribute('data-popup');
			let popup = document.getElementById(data);	

			popup.classList.add('active');

			hidePopup($(popup));
			setTimeout(function(){
				$("#stopSubscription").parent('footer').animate( { 'height': '200px' }, 500,
					function() {
						$(this).html(stopSubHtml);
					}
				);
			}, 500);
		});

		/* Demande de suppression de l'abonnement */
		$(document).on('click', '#stopSubscription', function(e){
			e.preventDefault();
			$(this).parent('footer').animate( { 'height': '200px' }, 500,
				function() {
					$(this).html(stopSubHtml);
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
								cloneEmail.attr('data-email', idEmail).attr('data-status',0);
								
								cloneEmail.find('span').removeClass('campaign').addClass('saved');

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

		/* Gestion de l'affichage des email */
		$(document).on('click', '[data-select-email]', function(e) {
			$('[data-select-email]').removeClass('active');
			$(this).addClass('active');
			
			let target =  $(this).attr('data-select-email');

			if(target == 'all'){
				$(".email").show();
			}
			else{
				$(".email").hide();
				$("[data-status='"+target+"']").show();
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
						console.log(html);
						var newDom = dom.replace(new RegExp('images/', 'g'), html.responseText);
						
						$('#previewUploadTemplate').parent('footer').html(
							'<button id="valideUploadOrder" class="button_default button_secondary">Valider le template</button>'
						);
						$('#orderPopup header').hide();
						$('#orderPopup .content_block').html(newDom);

		               	$(document).on('click', '#valideUploadOrder', function(e) {
		               		e.preventDefault();
							
							var container = $('#orderPopup .popup_container .content_block')[0];
							console.log(container);
							cheminImage = html.responseText;
							cheminThumbs = cheminImage.replace('images', 'thumbnails');
							html2canvas(container).then(canvas => {
								$.ajax({
									type: "POST",
									data: {thumbnail: canvas.toDataURL("image/png"), chemin: cheminThumbs },
									url : "?module=admin&action=commandes",
									complete:function(){
										$('#orderPopup [data-section]').each(function(){
											var id = Math.floor(Math.random() * 16777215).toString(16);
											$(this).attr('data-section', id);
											var section = $('[data-section="'+id+'"]')[0];
											cheminImage = html.responseText;
											cheminThumbs = cheminImage.replace('images', 'thumbnails');
											html2canvas(section).then(canvas => {
												$.ajax({
													type: "POST",
													data: {thumb: canvas.toDataURL("image/png"), nameThumb: id, chemin: cheminThumbs },
													url : "?module=admin&action=commandes",
													complete:function(data){
														console.log(id);
														console.log(cheminThumbs);
														console.log(data);
													}
												});
											});
										}).promise().done(function () { 
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
									}
								});
							});
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
		            data: {testemail: idOrder,commandevspublic:'commande'},
		            url : "?module=admin&action=commandes",
					complete(html) {
						window.location = "?module=user&action=email_builder&id="+html.responseText;
					},
		        });
			}
		});

		$(document).on('click', '#testPublic', function(e){
			e.preventDefault();
			if (!$(this).attr('data-appened')) {
				$(this).attr('data-appened', 'true');
				idOrder = $(this).parent('footer').attr('id');
				$.ajax({
		            type: "POST",
		            data: {testemail: idOrder, commandevspublic:'public'},
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
							'<button id="validePreview" class="button_default button_secondary">Valider la preview</button>'
						);
						$('#addTemplatePublic header').hide();
						$('#addTemplatePublic .content_block').html(newDom);
						
						$(document).on('click', '.content_block a', function(e){
							e.preventDefault();
						});

						$(document).on('click', '#validePreview', function(e){
							e.preventDefault();
							var container = $('#addTemplatePublic .content_block')[0];
							cheminImage = html.responseText;
							html2canvas(container).then(canvas => {
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
											var section = $('[data-section="'+id+'"]')[0];
											cheminImage = data[0];
											cheminThumbs = cheminImage.replace('images', 'thumbnails');
											html2canvas(section).then(canvas => {
												$.ajax({
													type: "POST",
													data: {thumb: canvas.toDataURL("image/png"), nameThumb: id, chemin: cheminThumbs },
													url : "?module=admin&action=templates",
												});
											});
										}).promise().done(function () { 
											dom = $('#addTemplatePublic .content_block').html();
											dom = dom.replaceAll('/preview/', '/template_public_'+templateID+'/images/');
											$.ajax({
												type: "POST",
												data: {templateID: templateID, DOM: dom},
												url : "?module=admin&action=templates",
												complete: function(html) {
													if (JSON.parse(html.responseText) === true) {
														$('#addTemplatePublic footer').html(
															'<button id="testPublic" class="button_default button_secondary">Tester le template</button>'
														).attr('id',templateID);
													} else {
														$('#addTemplatePublic').hide();
														displayNotif('Une erreur est survenue', false);
													}
												}
											});
										});
									}
								});
							});
						});
		            }
		        });
			}
		});
	}
/*=====  End of Template Admin  ======*/
});