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
var backgroundMail; // Valeur du fond de couleur
var DomMail; // Contenu du mail
var btnSave; // Bouton de sauvegarde
var saved = -1; // Etat de sauvegarde
var undoManager = new UndoManager(); // Creation du module undo/redo
undoManager.setLimit(15); // Limite du nombre de changements
var undoRedoStack = []; // Tableau des modifications
var family; // Tableau des polices
var familyName; // Police à exporter
var src; // Tableau des images
var srcImg; // Image à exporter
var mediasMobile; // Media Query
var viewDesktop = true;

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
    - VIII  :  Exporter le document
    - IX    :  Active la vue mobile

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
        btnSave.addClass('saving').removeClass('clic');
        saving = true
        
        $('[data-content]').removeClass('activeover');
        $('[contenteditable]').removeAttr('contenteditable');
        $('[spellcheck]').removeAttr('spellcheck');
        $('[data-section]').removeAttr('[data-mobile]');
        $('[data-medium-editor-element]').removeAttr('data-medium-editor-element');
        $('[data-medium-editor-editor-index]').removeAttr('data-medium-editor-editor-index');
        $('[medium-editor-index]').removeAttr('medium-editor-index');
        $('[data-original-title]').removeAttr('data-original-title');
        
        getContent();
        
        $.ajax({
            type: "POST",
            data: {emailTitle : titleMail, emailID: id_mail, emailDom: DomMail, emailbackground: backgroundMail},
            url : "?module=user&action=email_builder",
            success : function() {
                $('#loader_saving').html('<div class="snippet snippet__11"></div>');
                setTimeout(function(){
                    $('#loader_saving').html('<p class="safeguard_confirmed">sauvegardé <i class="material-icons">check</i></p>');
                    btnSave.removeClass('saving').addClass('clic');
                    saving = false;
                }, 4000);
                setTimeout(function(){
                    $('.safeguard_confirmed').animate({
                        opacity: 0
                    }, 1000);
                }, 7000);

                creatMediumEditor();
            }
        });
    }
}

// IV : Mise à jour des boutons Undo/Redo
var udpateBtn = function() {
    undoManager.setCallback(
       function updateUI() {
            $('#undo').prop('disabled', (!undoManager.hasUndo() || undoRedoStack.length <= 1));
            $('#redo').prop('disabled', !undoManager.hasRedo());
        }
    );
}

// V : Création de l'état de sauvegarde
function saveInStack(id, dem) {

    undoRedoStack[id] = dem;

    undoManager.add({
        undo: function () {
            var index = -1;
            for (var i = 0; i < undoRedoStack.length; i += 1) {
                if (i === id) {
                    index = i;
                }
            }
            if (index !== -1) {
                undoRedoStack.splice(index, 1);
            }
            var dem = undoRedoStack[undoRedoStack.length - 1];
            $('#storage_email').html(dem);
        },
        redo: function () {
            undoRedoStack[id] = dem;
            var step = undoRedoStack[undoRedoStack.length - 1];
            $('#storage_email').html(step);
        }
    });
}

// VI : Réserve un ID pour l'undo/redo
function createId() {
    return undoRedoStack.length;
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
    $(storage+' *').removeAttr('id');
}

// VIII : Exporter le document
function exportDocument(storageID) {
    src = [];
    family = [];
    getContent();
    $(storageID).html(DomMail);

    $(storageID+' [data-text],'+storageID+' [data-cta]').each(function(){
        $(this).addClass('fallback-font');
        familyName = $(this).css('font-family').split(',')[0].replace('"', '').replace('"', '').replace(' ', '+');
        if (!webSaveFonts.includes(familyName)) {
            if (!family.includes(familyName)) {
                family.push(familyName);
            }
        }
    });

    cleanAttr(storageID);
    for (var i = $(storageID+ ' img').length - 1; i >= 0; i--) {
        srcImg = $(storageID+ ' img').eq(i).attr('src');
        src.push(srcImg);
    }

    $.ajax({
        type: "POST",
        data: {domExport : $(storageID).html(), titleExport: titleMail, img: src, background: backgroundMail, fonts: family, ID:id_mail, fixGmail: fixGmailApp},
        url : "?module=user&action=email_builder",
        success : function(html) {
            $('.popup_overlay, #popupExport').addClass('active');
            $('#downloading').wrap('<a href="'+html+'" target="_blank"></a>');
        }
    });
}

// IX : Active la vue mobile
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

/*----------  Actions  ----------*/

// Démarrage des modules d'actions du builder
$(document).ready(function() {
    /* Mise à jour des boutons undo/redo */
    udpateBtn();

    /* Sauvegarde du builder */
    $(document).on("click", '#saveDocument', function() {
        saveBuilder($(this));
    });

    /* Annuler une modification */
    $(document).on('click', '#undo', function (e){ 
        undoManager.undo();
        console.log('undo');
        e.preventDefault();
    });

    /* Réaffecter une modification */
    $(document).on('click', '#redo', function (e){ 
        undoManager.redo();
        console.log('redo');
        e.preventDefault();
    });

    /* Sauvegarde et exporte le document */
    $(document).on('click', '#exportDocument', function(){
        saveBuilder($(this));
        exportDocument('#storage_email_to_export');
    });

    /* Sauvegarde du mail */
    saveInStack(createId(), $('#storage_email').html());

    /* Démarre le téléchargement de l'archive */
    $(document).on('click', '#downloading', function(){
        $('.outer_circle').addClass('active').css('stroke', '#0676B2');
        setTimeout(function(){
            $('.outer_circle').removeClass('active').css('stroke', 'transparent');
            $('.popup_overlay, .popup_container').removeClass('active');
        }, 2000);
    });

    $(document).on('click', '.popup_overlay', function(){
        $('.popup_overlay, .popup_container').removeClass('active');
    });

    $(document).on('click', '#mobileView', function(){
        mobileView(this);
    });

});


/*=====  End of Actions du builder  ======*/