/*==========================================
=            Actions du builder            =
==========================================*/
 
/**
    *
    * Librarie : JQuery
        - JS : lib/js/jquery
        - CSS : null
        - Github : https://github.com/jquery/jquery
        - Documentation : http://api.jquery.com/
    * 
    * Librarie : Javascript Undo Manager
        - JS : lib/js/undo-manager
        - CSS : null
        - Github : https://github.com/ArthurClemens/Javascript-Undo-Manager
        - Documentation : null
    *
    *
*/

/*----------  Variables  ----------*/

var saving = false; // Sauvegarde en cours
var id_mail; // ID du mail 
var titleMail; // Titre du document
var id_template = $('[data-template]').data('template'); // ID du template
var backgroundMail; // Valeur du fond de couleur
var DomMail; // Contenu du mail
var btnSave; // Bouton de sauvegarde
var family; // Tableau des polices
var familyName; // Police à exporter
var src; // Tableau des images
var srcImg; // Image à exporter
var mediasMobile; // Media Query
var viewDesktop = true; // Mode d'affichage du builder
var invalidExport; // Invalidité de l'export

// Bout de code pour correction dans de l'app Gmail
var fixGmailApp = '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="center"><table class="container" align="center" width="650" border="0" cellpadding="0" cellspacing="0"><tr><td height="30"><table class="gmapp" align="center" width="650" border="0" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;border:0px;"><tbody><tr><td><div class="gmapp" style="white-space:nowrap; font:15px courier; color:#F4F3F1;">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div></td></tr><tr><td><img class="gmapp" src="images/spacer.png" width="650" height="1" style="min-width:650px;width:650px" border="0" /></td></tr></tbody></table></td></tr></table></td></tr></table>';

/*----------  Functions  ----------*/

/**
    Séléctionnez le titre puis CTRL+D (Windows) ou CMD+D (Mac).
    - I     :  Récupèration des paramètres d'URL 
    - II    :  Récupèration des informations de l'email
    - III   :  Sauvegarde du builder
    - IV    :  Mise à jour des boutons Undo/Redo
    - V     :  Undo/Redo
    - VI    :  Réserve un ID pour l'undo/redo
    - VII   :  Nettoyage des attributs
    - VIII  :  Vérification des sources des images
    - IX    :  Exporter le document
    - X     :  Active la vue mobile
    - XI    :  Valider le template
    - XII   :  Annuler/Invalider le template

**/

// I : Récupèration des paramètres d'URL
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

// II : Récupèration des informations de l'email
function getContent(){
    id_mail = getUrlParameter('id');
    titleMail = $('#documentTitle').val();
    backgroundMail = $('#background_email').val();
    DomMail = $('#storage_email').html();
}

// III : Sauvegarde du builder
function saveBuilder(btnSave) {
    if (saving == false) {
        saving = false
        
        $('[data-content]').removeClass('activeover');
        $('[contenteditable]').removeAttr('contenteditable');
        $('[spellcheck]').removeAttr('spellcheck');
        $('[data-section]').removeAttr('[data-mobile]');
        $('[data-medium-editor-element]').removeAttr('data-medium-editor-element');
        $('[data-medium-editor-editor-index]').removeAttr('data-medium-editor-editor-index');
        $('[medium-editor-index]').removeAttr('medium-editor-index');
        $('[data-original-title]').removeAttr('data-original-title');
        $('#storage_email *').removeClass('active noactive');
        
        getContent();
        
        DOM = document.getElementById('storage_email');

        $(btnSave).parents('.header_builder').find('.label_saved_name').html('Enregistrement en cours...');

        html2canvas(DOM, {
            onrendered: function(canvas) {
                $.ajax({
                    type: "POST",
                    data: {thumbs: canvas.toDataURL("image/png"), emailTitle : titleMail, emailID: id_mail, emailDom: DomMail, emailbackground: backgroundMail},
                    url : "?module=user&action=email_builder",
                    success : function() {
                        setTimeout(function() {
                            $(btnSave).parents('.header_builder').find('.label_saved_name').html('Toutes les modifications ont été sauvegardées');
                        }, 1500);
                        saving = false;
                        creatMediumEditor();
                    }
                });
            }
        });
    }
}

function reloadMediumEditor() {
    $('[data-medium-editor-element]').removeAttr('data-medium-editor-element');
    $('[data-medium-editor-editor-index]').removeAttr('data-medium-editor-editor-index');
    $('[data-medium-focused]').removeAttr('data-medium-focused');
    $('[data-placeholder]').removeAttr('data-placeholder');
    $('[medium-editor-index]').removeAttr('medium-editor-index');
    creatMediumEditor();
}

var h = []; // historique, au load de la page, l'historique commence donc à 1 item.
var positionInArray; // On va évidemment bouger dans l'array, il faut savoir où on est.
var contentToObserve = document.getElementById('storage_email'); // Le contenu qui doit être observé
var btnUndo = document.getElementById('undo'); // Bouton Undo
var btnRedo = document.getElementById('redo'); // Bouton Redo

var buttonsUndoRedo = [btnUndo, btnRedo]; // Tableau des boutons
var hLengthMax = 10; // Taille de l'historique max


function actionAfterUndoRedo(element){
    if (element) { 
        $('[data-target]').click();
    } else {
        hideSidebar();
    }
    reloadMediumEditor();
}

function saveInStack(object) {
    if (h.length == 0) {
        for (var i = buttonsUndoRedo.length - 1; i >= 0; i--) {
            buttonsUndoRedo[i].setAttribute('disabled', 'disabled');
        }
    } else {
        buttonsUndoRedo[0].removeAttribute('disabled');
        buttonsUndoRedo[1].setAttribute('disabled', 'disabled');
    }

    var arrayStack = [contentToObserve.innerHTML];

    if (object) {
        var proto = document.querySelector(object);
    } else {
        var proto = undefined;
    }
    arrayStack.push(proto);
    h.push(arrayStack);
    positionInArray = h.length - 1;
    if (h.length > hLengthMax) {
        h.shift();
    }
}

function undo() {
    if (positionInArray - 1 >= 0) {
        positionInArray =  positionInArray - 1;
        var lastDOM = h[positionInArray][0];
        var obj = h[positionInArray][1];
        contentToObserve.innerHTML = lastDOM;
        actionAfterUndoRedo(obj);
        buttonsUndoRedo[1].removeAttribute('disabled');
        if (positionInArray == 0) {
            buttonsUndoRedo[0].setAttribute('disabled', 'disabled');
        }
    }
}

function redo() {
    if (positionInArray + 1 < h.length) {
        positionInArray = positionInArray + 1;
        var lastDOM = h[positionInArray][0];
        var obj = h[positionInArray][1];
        contentToObserve.innerHTML = lastDOM;
        buttonsUndoRedo[0].removeAttribute('disabled');
        actionAfterUndoRedo(obj);
        if (positionInArray + 1 == h.length) {
            buttonsUndoRedo[1].setAttribute('disabled', 'disabled');
        }
    }
}

// VII : Nettoyage des attributs
function cleanAttr(storage) {
    $(storage+' [data-content]').removeClass('activeover');
    $(storage+' [contenteditable]').removeAttr('contenteditable');
    $(storage+' [spellcheck]').removeAttr('spellcheck');
    $(storage+' [data-medium-editor-element]').removeAttr('data-medium-editor-element');
    $(storage+' [data-medium-editor-editor-index]').removeAttr('data-medium-editor-editor-index');
    $(storage+' [data-medium-focused]').removeAttr('data-medium-focused');
    $(storage+' [data-placeholder]').removeAttr('data-placeholder');
    $(storage+' [medium-editor-index]').removeAttr('medium-editor-index');
    $(storage+' [data-original-title]').removeAttr('data-original-title');
    $(storage+' [data-text]').removeAttr('data-text');
    $(storage+' [data-cta]').removeAttr('data-cta');
    $(storage+' [data-img]').removeAttr('data-img');
    $(storage+' [data-spacer]').removeAttr('data-spacer');
    $(storage+' [data-section]').removeAttr('data-section');
    $(storage+' [data-content]').removeAttr('data-content');
    $(storage+' [data-target]').removeAttr('data-target');
    $(storage+' [data-target-parent]').removeAttr('data-target-parent');
    $(storage+' [data-parent-target]').removeAttr('data-parent-target');
    $(storage+' [data-href]').removeAttr('data-href');
    $(storage+' [data-mobile]').removeAttr('data-mobile');
    $(storage+' .medium-editor-element').removeClass('medium-editor-element');
    $(storage+' *')
    .removeAttr('id')
    .removeAttr('role')
    .removeAttr('aria-multiline')
    .removeClass('active')
    .removeClass('noactive');
}

// IX : Exporter le document
function exportDocument(storageID) {

    let popup = $('#popupExport');
    $('#popupExport .popup_container').html('<div class="cssload-thecube">'+
        '<div class="cssload-cube cssload-c1"></div>'+
        '<div class="cssload-cube cssload-c2"></div>'+
        '<div class="cssload-cube cssload-c4"></div>'+
        '<div class="cssload-cube cssload-c3"></div>'+
        '</div>'+
        '<p>Merci de patienter...</p>');

    popup.addClass('active');

    hidePopup(popup);

    src = [];
    family = [];
    getContent();
    $(storageID).html(DomMail);

    $(storageID+' [data-text],'+storageID+' [data-cta]').each(function(){
        familyName = $(this).css('font-family').split(',')[0].replace('"', '').replace('"', '').replace(' ', '+');
        if (!webSaveFonts.includes(familyName)) {
            if (!family.includes(familyName)) {
                family.push(familyName);
            }

            var fallBackFonts = $(this).css('font-family').split(',');
            familyName = familyName.replace('+', ' ');
            console.log(familyName);

            $(this).css('font-family', fallBackFonts[1]+', '+fallBackFonts[2]+', '+familyName+'');
            console.log( $(this).css('font-family'));
        }
    });

    cleanAttr(storageID); 

    for (var i = $(storageID+ ' img').length - 1; i >= 0; i--) {
        srcImg = $(storageID+ ' img').eq(i).attr('src');
        src.push(srcImg);
    }

    $(storageID+' a').each(function(){
        if ($(this).children('img')[0] != undefined) {
            if ($(this).attr('href') == '') {
                $(this).children('img').unwrap();
            }
        }

        else {
            if ($(this).attr('href') == '') {
                $(this).attr('href', '#');
            }
        }
    });

    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };

    var html = $(storageID).html();
    for (var i = family.length - 1; i >= 0; i--) {
        var f = family[i].replace('+', ' ');
        html = html.replaceAll('&quot;', '');
        html = html.replaceAll(f, "'"+f+"'");
    }

    $.ajax({
        type: "POST",
        data: {domExport : html, titleExport: titleMail, img: src, background: backgroundMail, fonts: family, ID:id_mail, fixGmail: fixGmailApp},
        url : "?module=user&action=email_builder",
        success : function(html) {
            setTimeout(function() {
            $('#popupExport .popup_container').html(
                '<button download onclick="location.href=&#39;'+encodeURI(html)+'&#39;" class="button_default button_secondary">Démarrer le téléchargement</button>'+
                '<p>Cliquez sur le bouton <u>ci-dessus</u> pour démarrer l\'exportation.</p>'
            );
            }, 4000); 
        }
    });
}

// X : Active la vue mobile
function mobileView(btn) {
    $(btn).toggleClass('active');
    if (viewDesktop) {
        mediasMobile = $('#storage_medias').html().replace('and (max-width:600px)', '');
        $("[data-section]").attr('data-mobile', 'true');
        $('#storage_medias').html('<style>'+mediasMobile+'</style>');
        viewDesktop = false;
    }
    else {
        $('[data-mobile]').removeAttr('data-mobile');
        $('#storage_medias').html(mediasMobile);
        viewDesktop = true;
    }
}

// XI : Valider le template
function valideTemplate(orderID) {
    $.ajax({
        type: "POST",
        data: {valideTemplate: orderID},
        url : "?module=admin&action=commandes",
        success : function(html) {
            window.location = html;
        }
    });
}

// XII : Annuler/Invalider le template
function cancelTemplate(orderID) {
    $.ajax({
        type: "POST",
        data: {cancelUpload: orderID},
        url : "?module=admin&action=commandes",
        success : function(html) {
            window.location = html;
        }
    });
}

/*----------  Actions  ----------*/

// Démarrage des modules d'actions du builder
$(document).ready(function() {

    /* Création du premier élément dans l'historique */
    saveInStack();

    /* Sauvegarde du builder */
    $(document).on("click", '#saveDocument', function() {
        saveBuilder($(this));
    });

    /* Sauvegarde et exporte le document */
    $(document).on('click', '#exportDocument', function(){
            // saveBuilder($(this));
            exportDocument('#storage_email_to_export');
    });

    /* Activation de l'undo / redo */
    $(document).on('click', '#undo', function() { undo() });
    $(document).on('click', '#redo', function() { redo() });

    /* Démarre le téléchargement de l'archive */
    $(document).on('click', '#downloading', function(){
        $('.outer_circle').addClass('active').css('stroke', '#0676B2');
        setTimeout(function(){
            $('.outer_circle').removeClass('active').css('stroke', 'transparent');
            $('.popup_overlay, .popup_container').removeClass('active');
        }, 2000);
    });

    /* Valider le template */
    $(document).on('click', '#valideTemplate', function(){
        valideTemplate(id_template);
    });

    /* Invalider le template */
    $(document).on('click', '#cancelTemplate', function(){
        cancelTemplate(id_template);
    });

    /* Active la vue mobile */
    $(document).on('click', '#mobileView', function(){
        mobileView(this);
    });
});

/*=====  End of Actions du builder  ======*/