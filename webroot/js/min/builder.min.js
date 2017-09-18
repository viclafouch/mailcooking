/*=======================================
=            Edition d'image            =
=======================================*/
 
/**
    *
    * Librarie : JQuery
        - JS : lib/js/jquery
        - CSS : null
        - Github : https://github.com/jquery/jquery
        - Documentation : http://api.jquery.com/
    * 
    * Librarie : Cropper
        - JS : lib/js/croppie
        - CSS : lib/css/croppie
        - Github : https://github.com/foliotek/croppie
        - Documentation : http://foliotek.github.io/Croppie/#documentation
    *
    *
*/

/*----------  Variables  ----------*/

var inCroppie = false; // Statut du croppie
var imgToEdit; // L'image à editer
var imgHeight; // Hauteur de l'image
var imgWidth; // Largeur de l'image
var imgAlt; // Attribut alt de l'image
var imgLink; // Attribut href de l'image
var imgEdit; // L'image en cours d'édition
var keys = {37: 1, 38: 1, 39: 1, 40: 1}; // touches directionnelles
var id_mail; // ID du mail 

// Contenu du container de la popup
var cropper = '<div id="cropperimg"></div><p><input id="newImg" type="file" accept=".png, .jpeg, .jpg" spellcheck="false" autocomplete="off" /></p><p><input id="altImg" type="text" spellcheck="false" autocomplete="off" placeholder="Tag alternatif"></p><button id="saveImg" class="button_default button_secondary">Sauvegarder</button>';
/*----------  Functions  ----------*/

/**
    Séléctionnez le titre puis CTRL+D (Windows) ou CMD+D (Mac).
    - I     :  Récupère les paramètres d'URL
    - II    :  Création du Cropper
    - III   :  Insertion d'un nouveau fichier
    - IV    :  Sauvegarde des modifications
    - V     :  Annule des modifications
    - VI    :  Constructeur
**/

// I : Récupère les paramètres d'URL
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

// II :  Création du Cropper
var creatCroppie = function($url) {

    imgEdit = $('#cropperimg').croppie({
        viewport: {
            width: imgWidth,
            height: imgHeight,
            type: 'square'
        },
        boundary: {
            width: imgWidth + 100,
            height: imgHeight + 100
        },
        /* Autorise le zoom (avec le range) */
        enableZoom: true,
        /* Ajoute également la molette de la souris */
        mouseWheelZoom: true,
        /* Afficher le range */
        showZoomer: true,
        /* Interdit de modifier les proportions */
        enforceBoundary: true,
        /* Ajoute une/des classes css */
        customClass: 'croppie_custom',
        /* Désactive l'orientation */
        enableOrientation: false
    });

    imgEdit.croppie('bind', {
        /* URL de l'image séléctionnée */
        url: ($url),
        /* Objectif du zoom */
        points: [],
        /* Orientation */
        orientation: 1

    }).then(function(){
        /* Zoom par defaut */
       imgEdit.croppie('setZoom', 0)
    });
}

// III : Insertion d'un nouveau fichier
var changeCroppie = function(input) {
    $(input).change(function() {
        var file = this.files[0];
         
        /* Verification du poids du fichier inséré */
        if (file.size > 2500000 || file.fileSize > 2500000) {
           alert('fichier trop volumineux');
           this.value = null;
        } else {
            /* Destruction du DOM */
            imgEdit.croppie('destroy');

            /* Lecture de l'URL et création du Croppie */
            var reader = new FileReader();
            reader.onload = function(e) {
                creatCroppie(e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
}

// IV : Sauvegarde des modifications
var saveCroppie = function(input, selection) {
    $(input).on('click', function() {
        $alt = $('#altImg').val();
        /* Créer une image base64 */
        imgEdit.croppie('result', {
            type: 'base64',
            format: 'png',
            size: 'viewport',
            quality: 1,
            circle: false
        }).then(function (resp) {
            /* Insertion des attributs */
            selection.attr('alt', $alt);

            id_mail = getUrlParameter('id');

            /* Créer l'image dans le dossier client */
            $.ajax({
                type: "POST",
                data: {new_img : resp, id_mail: id_mail},
                url : "?module=user&action=email_builder",
                success : function(html) {
                    selection.attr('src', html);
                    saveInStack(true);
                }
            });
        });

        $('#popupCroppie').removeClass('active');
    });
}

// V : Annule des modifications
var closeCroppie = function(el) {
    $(el).on('click', function(e){
        inCroppie = false;
        $('#popupCroppie').removeClass('active');

        setTimeout(function(){
            imgEdit.croppie('destroy');
        }, 500);

    });
    $(document).on('keydown', function(e) {
        if (inCroppie) {
            switch (e.keyCode) {
            case 27:
                e.preventDefault();
                $(el).trigger('click');
                break;
            };
        }
    });
}

// VI : Constructeur
var imgCropper = function(selection) {

    /* Récupération des infos de l'image séléctionnée */
    imgToEdit   =   selection.attr('src');
    imgAlt      =   selection.attr('alt');
    imgHeight   =   parseFloat(selection.height());
    imgWidth    =   parseFloat(selection.width());

    /* Insertion du contenu HTML */
    $('#popupCroppie .popup_container').html(cropper);

    /* Insertion de l'attribut ALT */
    $('#altImg').val(imgAlt);

    //  Création du croppie de l'image séléctionnée 
    creatCroppie(imgToEdit);

    /* Affichage de la popup */
    let popup = $('#popupCroppie');
    popup.addClass('active');

    /* Changement de cropper à l'insertion d'un fichier */
    changeCroppie('#newImg');

    //  Sauvegarde de l'image dans le serveur 
    saveCroppie('#saveImg', selection);

    // /* Ferme et annule les modifications d'image */
    closeCroppie('#popupCroppie > .popup_background');
}

/*----------  Actions  ----------*/

// Démarre la modification d'image
$('[data-change="img"]').bind('click', function() {
    if ($(this).attr('data-tocroppie')) {
        inCroppie = true;
        selectedID = $(this).attr('data-tocroppie');
        selectedIMG = $("[data-img='" + selectedID + "']");
        imgCropper(selectedIMG);
    }
});

/*=====  End of Edition d'image  ======*/
/*========================================
=            Edition du texte            =
========================================*/

/**
    *
    * Librairie : JQuery
        - JS : lib/js/jquery
        - CSS : null
        - Github : https://github.com/jquery/jquery
        - Documentation : http://api.jquery.com/
    * 
    * Librairie : Medium Editor
        - JS : lib/js/medium-editor
        - CSS : lib/css/medium-editor
        - Github : https://github.com/yabwe/medium-editor
        - Documentation : http://api.jqueryui.com/
    *
    * Librairie : jQuery MiniColors
        - JS : lib/js/jquery-minicolors
        - CSS : lib/css/jquery-minicolors
        - Github : https://github.com/claviska/jquery-minicolors
        - Documentation : http://labs.abeautifulsite.net/jquery-minicolors/
    *
*/

/*----------  Variables  ----------*/

var dataImg; // ID de l'image séléctionnée
var alignmentSection; // Alignement de l'objet
var colorSection; // Couleur de texte de l'objet
var backgroundSection; // Couleur de fond de l'objet
var familySection; // Police de texte de l'objet
var height; // Hauteur de l'objet
var lineSection; // Interlignage de l'objet
var linkSection; // Lien de redirection de l'objet
var paddingTopSection; // Espacement haut de l'objet
var paddingRightSection; // Espacement droit de l'objet
var paddingBottomSection; // Espacement bas de l'objet
var paddingLeftSection; // Espacement gauche de l'objet
var borderSizeTopSection; // Taille de bordure haute de l'objet
var borderSizeRightSection; // Taille de bordure droite de l'objet
var borderSizeBottomSection; // Taille de bordure basse de l'objet
var borderSizeLeftSection; // Taille de bordure gauche de l'objet
var borderColorTopSection; // Couleur de bordure haute de l'objet
var borderColorRightSection; // Couleur de bordure droite de l'objet
var borderColorBottomSection; // Couleur de bordure basse de l'objet
var borderColorLeftSection; // Couleur de bordure gauche de l'objet
var borderRadius; // Taille de border radius
var target; // Cible à modifier
var parent; // Parent Cible
var parentLink; // Parent direct href de l'objet

var olderValue; // Valeur sauvegardée
var val; // Valeur en cours d'insertion
var max; // Valeur max à insérer
var min; // Valeur min à insérer

// Les polices websave
var webSaveFonts = ['Arial','Andale Mono','Arial Black','Bitstream Vera Sans','Courier','Courier New','DejaVu Serif','DejaVu Sans Mono','Georgia','Geneva','Helvetica','Impact','Kalimati','Liberation Sans','Liberation Mono','Lucida Console','FreeSans','FreeMono','Times New Roman', 'Times','Trebuchet MS','FreeSerif', 'Liberation Serif','Lucida Sans','Lucida Grande','Lucida Sans Unicode','Luxi Sans','monospace','Monaco','Norasi','serif', 'sans-serif','Verdana','Tahoma'];

var flagEditor;
var flagSpin;
var flagMinicolor;

/*----------  Functions  ----------*/

/**
    Séléctionnez le titre puis CTRL+D (Windows) ou CMD+D (Mac).
    - I     :  Création de Medium Editor 
    - II    :  Transformation d'un rgb en hex
    - III   :  Limite le multi event
    - IV    :  Concentration des données modifiées vers la cible
    - V     :  Concentration des données modifiées vers le parent cible
    - VI    :  Cible == Text
    - VII   :  Cible == Img
    - VIII  :  Cible == Cta
    - IX    :  Cible == Spacer
    - X     :  Affichage des items selon le clic
    - XI    :  Spinner +/- des items
    - XII   :  Gestion du minicolor sur les items
    - XIII  :  Récupération/Modification de l'alignement
    - XIV   :  Récupération/Modification de la taille de texte
    - XV    :  Récupération/Modification de la couleur de texte
    - XVI   :  Récupération/Modification de la couleur de fond
    - XVII  :  Récupération/Modification de la police de texte
    - XVIII :  Récupération/Modification de l'interlignage
    - XIX   :  Récupération/Modification de la hauteur
    - XX    :  Récupération/Modification du lien de redirection
    - XXI   :  Récupération/Modification de l'espacement
    - XXII  :  Récupération/Modification de la taille des bordures
    - XXIII :  Récupération/Modification de la couleur des bordures
    - XXIV  :  Récupération/Modification du contour des bordures
    - XXV   :  Action des différents items à la disparition des items
    - XXVI  :  Disparition des items
**/

// I : Création de Medium Editor
var creatMediumEditor = function() {
    new MediumEditor('[data-text]', {
        targetBlank: true,
        spellcheck: false,
        toolbar: {
            // Left style
            diffLeft: -10,
            // top style
            diffTop: -10,
            // Menu apparait/disparait au clic
            static: false,
            // Ajout de boutons
            buttons: 
            [
                { name: 'bold', contentDefault: '<i class="material-icons">format_bold</i>' },
                { name: 'italic', contentDefault: '<i class="material-icons">format_italic</i>' },
                { name: 'underline', contentDefault: '<i class="material-icons">format_underlined</i>' },,
                { name: 'strikethrough', contentDefault: '<i class="material-icons">format_strikethrough</i>' },
                { name: 'anchor', contentDefault: '<i class="material-icons">insert_link</i>' },
                { name: 'removeFormat', contentDefault: '<i class="material-icons">format_clear</i>' }
            ]
        },

        // Formulaire pour le lien
        anchor: {
            // Si on souhaite ajouter un bouton en plus
            customClassOption: false,
            customClassOptionText: 'Text',
            // Empêche les espaces
            linkValidation: true,
            // Texte du placeholder
            placeholderText: 'Insérez un lien de redirection',
            // Ajouter un checkbox pour le target=_blank?
            targetCheckbox: false,
            targetCheckboxText: 'Text'
        },

        // Si le user colle qq chose dans la section
        paste: {
            // Force le texte brut
            forcePlainText: true,
            // On clean toutes les balises/attr/meta du clipboard
            cleanPastedHTML: false,
            // Si on veut remplacer des valeurs
            cleanReplacements: [],
            // Clean les attributs
            cleanAttrs: ['class', 'style', 'dir', 'id'],
            // Clean les balises et leur enfants
            cleanTags: ['meta','script','style','img','object','iframe'],
            // Supprime une balise MAIS garde les balises enfantes
            unwrapTags: []
        },

        // Si la section texte est vide de texte
        placeholder: {
            // Le placeholder
            text: 'Votre texte ici...',
            // Cacher au clic ou pas
            hideOnClick: true
        },

        // Possibilité d'utiliser les touches du clavier
        keyboardCommands: {
            commands: [
                {
                    // La cible
                    command: 'bold',
                    // La commande
                    key: 'B',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                },
                {
                    // La cible
                    command: 'italic',
                    // La commande
                    key: 'I',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                },
                {
                    // La cible
                    command: 'underline',
                    // La commande
                    key: 'U',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                },
                {
                    // La cible
                    command: 'anchor',
                    // La commande
                    key: 'K',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                },
                {
                    // La cible
                    command: 'strikethrough',
                    // La commande
                    key: 'M',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                }
            ],
        },

        // Rend un lien cliquable (créer une balise <a> autour du lien collé)
        autoLink: true,
        // Empêche le dragging & dropping dans la section
        imageDragging: false,
    }).subscribe('editableInput', function (event, editable) {
        flagEditor = true;
    });

    new MediumEditor('[data-cta] > p', {
        targetBlank: false,
        spellcheck: false,
        anchorPreview: false,
        toolbar: {
            // Left style
            diffLeft: -10,
            // top style
            diffTop: -10,
            // Menu apparait/disparait au clic
            static: false,
            // Ajout de boutons
            buttons: 
            [
                { name: 'bold', contentDefault: '<i class="material-icons">format_bold</i>' },
                { name: 'italic', contentDefault: '<i class="material-icons">format_italic</i>' },
                { name: 'underline', contentDefault: '<i class="material-icons">format_underlined</i>' },
                { name: 'strikethrough', contentDefault: '<i class="material-icons">format_strikethrough</i>' }
            ]
        },

        // Si le user colle qq chose dans la section
        paste: {
            // Force le texte brut
            forcePlainText: true,
            // On clean toutes les balises/attr/meta du clipboard
            cleanPastedHTML: false,
            // Si on veut remplacer des valeurs
            cleanReplacements: [],
            // Clean les attributs
            cleanAttrs: ['class', 'style', 'dir', 'id'],
            // Clean les balises et leur enfants
            cleanTags: ['meta','script','style','img','object','iframe'],
            // Supprime une balise MAIS garde les balises enfantes
            unwrapTags: []
        },

        // Si la section texte est vide de texte
        placeholder: {
            // Le placeholder
            text: '',
            // Cacher au clic ou pas
            hideOnClick: true
        },

        // Possibilité d'utiliser les touches du clavier
        keyboardCommands: {
            commands: [
                {
                    // La cible
                    command: 'bold',
                    // La commande
                    key: 'B',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                },
                {
                    // La cible
                    command: 'italic',
                    // La commande
                    key: 'I',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                },
                {
                    // La cible
                    command: 'underline',
                    // La commande
                    key: 'U',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                },
                {
                    // La cible
                    command: 'strikethrough',
                    // La commande
                    key: 'M',
                    // CTRL
                    meta: true,
                    // Schift
                    shift: false,
                    // ALT
                    alt: false
                }
            ],
        },

        // Rend un lien cliquable (créer une balise <a> autour du lien collé)
        autoLink: false,
        // Empêche le dragging & dropping dans la section
        imageDragging: false,
    }).subscribe("editableKeydownEnter", function (event, element) {
        event.preventDefault();
        event.stopPropagation();
        return false;
    }.bind(event));

    $(document).on('focusout', '[data-cta] > p', function(){
        if ($(this).text() == '') {
            $(this).text('Votre texte ici');
        }
    });

    $('.medium-editor-toolbar-save').html('<i class="material-icons">check</i>');
    $('.medium-editor-toolbar-close').html('<i class="material-icons">close</i>');
}

// II : Transformation d'un rgb en hex
function rgb2hex(rgb){
    rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
    return (rgb && rgb.length === 4) ? "#" +
    ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
    ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
    ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
}

// III : Limite le multi event
var checkHandle = function(event) {
    event.preventDefault();
    if (!event.handled) {
        event.handled = true
        return event.handled;
    }
}

// IV : Concentration des données modifiées vers la cible
function targetTheTarget(element) {
    $('[data-text], [data-img], [data-cta], [data-spacer]').removeAttr('data-target');
    $('[data-content]').removeAttr('data-parent-target');
    $('[data-content] a').removeAttr('data-href');
    $(element).attr('data-target', 'true');
    target = $('[data-target]');
    return target;
}

// V : Concentration des données modifiées vers le parent cible
function targetTheTargetParent(element) {
    $(element).parents('[data-content]').attr('data-parent-target', 'true');
    parent = '[data-parent-target]';
    return parent;
}

// VI : Cible == Text
function clicToText(element) {
    $('[data-display-text]').show();
    alignmentText(element);
    sizeText(element);
    colorText(element);
    backgroundText(targetTheTargetParent(element));
    familyText(element);
    lineText(element);
    paddingObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
}

// VII : Cible == Img
function clicToImg(element) {
    $(element).removeAttr('border');
    $('[data-display-img]').show();
    linkObjet(element);
    heightObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
    dataImg = $(element).attr('data-img');
    $('[data-change="img"]').attr('data-tocroppie', dataImg);
}

// VIII : Cible == Cta
function clicToCta(element) {
    $('[data-display-cta]').show();
    sizeText(element);
    colorText(element);
    backgroundText(element);
    familyText(element);
    linkObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
    borderRadiusObjet(element);
}

// IX : Cible == Spacer
function clicToSpacer(element) {
    $('[data-display-spacer]').show();
    backgroundText(element);
    heightObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
}

// X : Affichage des items selon le clic
function editSidebar(element) {
    element = '[data-target]';
    $('.field_item_sidebar').hide();
    $("[data-menu]#items_sidebar").trigger( "click" );

    if ($(element).attr('data-text')) { clicToText(element); }
    else if ($(element).attr('data-img')) { clicToImg(element) }
    else if ($(element).attr('data-cta')) { clicToCta(element) }
    else if ($(element).attr('data-spacer')) { clicToSpacer(element) }
}

// XI : Spinner +/- des items
function changeSpinner(change, element) {
    let input = $(change);
    let style = input.attr('data-change');

    if ($(element).attr('data-img')) {
       $('[data-change="height"]')
            .attr('data-max', '550')
            .attr('data-min', '10');
    } else {
         $('[data-change="height"]')
            .attr('data-max', '150')
            .attr('data-min', '15');
    }

    let max = parseFloat(input.attr('data-max'));
    let min = parseFloat(input.attr('data-min'));

    input.spinner( "option", "max", max );
    input.spinner( "option", "min", min );

    $(function() {        
        input.spinner({
            spin: function(event, ui) {
                var oldValue = parseFloat($(element).css(style));
                $(element).css(style, ui.value+'px');
                if ($(element).attr('data-text')) {
                    if ($(event.target).attr('data-change') == 'font-size') {
                        $('[data-change="line-height"]')
                        .val(Math.round(ui.value * 1.5))
                        .attr('value', Math.round(ui.value * 1.5))
                        .attr('aria-valuenow', Math.round(ui.value * 1.5))
                        .attr('data-min', ui.value)
                        .attr('aria-valuemin', ui.value)
                        .attr('data-max', ui.value * 3)
                        .attr('aria-valuemax', ui.value * 3);
                        $(element).css('line-height', $('[data-change="line-height"]').val()+'px');

                        $('[data-change="line-height"]').spinner( "option", "max", ui.value * 3);
                        $('[data-change="line-height"]').spinner( "option", "min", ui.value );
                    }
                }
                if (oldValue != ui.value) {
                    flagSpin = input;
                }
            },
            change: function(event, ui) {
                var oldValue = parseFloat($(element).css(style));
                val = event.target.value;
                if (val == '') {
                    olderValue = parseFloat($(element).css(style));
                    $(element).css(style, olderValue+'px');
                    input.attr('value', olderValue).val(olderValue);
                    input.attr('aria-valuenow', olderValue);
                    val = olderValue;
                }
                else if (val < min) {
                    $(element).css(style, min+'px');
                    input.attr('value', min).val(min);
                    input.attr('aria-valuenow', min);
                    val = min;
                }
                else if (val > max) {
                    $(element).css(style, max+'px');
                    input.attr('value', max).val(max);
                    input.attr('aria-valuenow', max);
                    val = max;
                }
                else {
                    $(element).css(style, val+'px');
                    input.attr('value', val);
                }
                if ($(element).attr('data-text')) {
                    if ($(event.target).attr('data-change') == 'font-size') {
                        $('[data-change="line-height"]')
                        .val(Math.round(val * 1.5))
                        .attr('value', Math.round(val * 1.5))
                        .attr('aria-valuenow', Math.round(val * 1.5))
                        .attr('data-min', val)
                        .attr('aria-valuemin', val)
                        .attr('data-max', val * 3)
                        .attr('aria-valuemax', val * 3);
                        $(element).css('line-height', $('[data-change="line-height"]').val()+'px');
                    }
                }
                if (parseFloat($(element).css(style)) != oldValue) {
                    flagSpin = input;
                }
            }  
        });   
    });
}

// XII : Gestion du minicolor sur les items
function changeMinicolor(change, element) {
    var style = $(change).attr('data-change');
    $(document).on('change', change, function(e){
        if (checkHandle(e)) {
            styleValue = $(this).val();
            flagMinicolor = styleValue;
            $(element).css(style, styleValue);
        }
    });
    $(document).on('blur', change, function(e){
        if (checkHandle(e)) {
            if (flagMinicolor) {
                saveInStack(true);
                flagMinicolor = undefined;
            }
        }
    });
}

// XIII : Récupération/Modification de l'alignement
function alignmentText(element) {
    alignmentSection = $(element).css('text-align');
    $('.format_align').removeClass('active');
    $('#'+alignmentSection+'').addClass('active');

    (function change(){
        $(document).on('click', '.format_align', function(e){
            if (!$(this).hasClass('active') && checkHandle(e)) {
                $('.format_align').removeClass('active');
                $(this).addClass('active');
                alignmentSection = $(this).attr('id');
                $(element).css('text-align', alignmentSection);
                saveInStack(true);
            }
        });
    })();
}

// XIV : Récupération/Modification de la taille de texte
function sizeText(element) {
    let input = '[data-change="font-size"]';
    sizeSection = parseFloat($(element).css('font-size'));
    $(input).val(sizeSection).attr('value', sizeSection);

    changeSpinner(input, element);
}

// XV : Récupération/Modification de la couleur de texte
function colorText(element) {
    let input = '[data-change="color"]';
    colorSection = rgb2hex($(element).css('color'));
    $(input).attr('value', colorSection).val(colorSection).minicolors('value',colorSection);

    changeMinicolor(input, element);
}

// XVI : Récupération/Modification de la couleur de fond
function backgroundText(element) {
    let input = '[data-change="background-color"]';
    backgroundSection = rgb2hex($(element).css('background-color'));
    $(input).attr('value', backgroundSection).val(backgroundSection).minicolors('value',backgroundSection);

    changeMinicolor(input, element);
}

// XVII : Récupération/Modification de la police de texte
function familyText(element) {
    let input = $('[data-change="font-family"]');
    familySection = $(element).css('font-family').split(', ');
    newFamilySection = familySection[0].replace('"', '').replace('"', '');
    input.find('option').removeAttr('selected');
    input.find('#'+newFamilySection).attr('selected', 'true');
    input.val(newFamilySection);

    (function change() {
        $(document).on('change', '[data-change="font-family"]', function(e) {
            if (checkHandle(e)) {
                input = $(this);
                val = input.val();
                if (webSaveFonts.includes(val)) {
                    $(element).css('font-family', val);
                } else {
                     $(element).css('font-family', val+", Arial, sans-serif");
                }
                $(element).attr('style', $(element).attr('style').replace('"', "'").replace('"', "'"));
                saveInStack(true);
            }
        });
    })();
}

// XVIII : Récupération/Modification de l'interlignage
function lineText(element) {
    let input = '[data-change="line-height"]';
    lineSection = parseFloat($(element).css('line-height'));
    sizeSection = parseFloat($(element).css('font-size'));

    if (!lineSection) {
        $(input).val(sizeSection * 1.5).attr('value', sizeSection * 1.5);
    }
    else {
        $(input).val(lineSection).attr('value', lineSection);
    }

    $(input).attr('data-min', sizeSection);
    $(input).attr('data-max', sizeSection * 3);
    $(input).attr('aria-valuemin', sizeSection);
    $(input).attr('aria-valuemax', sizeSection * 3);

    changeSpinner(input, element);
}

// XIX : Récupération/Modification de la hauteur
function heightObjet (element) {
    let input = '[data-change="height"]';
    height = parseFloat($(element).attr('height'));
    $(input).val(height).attr('value', height);

    changeSpinner(input, element);
}

// XX : Récupération/Modification du lien de redirection
function linkObjet(element){
    let input = $('[data-change="link"]');

    if ($(element).attr('data-cta')) {
        linkSection = $(element).attr('href');
        input.val(linkSection).attr('value', linkSection);
    }
    else if ($(element).attr('data-img')) {
        $(element).parent('a').attr('data-href', 'true');
        if ($(element).parent('[data-href]').length != 0) {
            linkSection = $('[data-href]').attr('href');
            input.val(linkSection).attr('value', linkSection);
        }
        else {
            input.val('').attr('value', '');
            $(element).wrap('<a title="" href="" target="_blank" data-href="true"></a>')
        }
    }

    (function change(){
        $(document).on('change', '[data-change="link"]', function(e){
            if (checkHandle(e)) {
                linkSection = $(this).val();
                if ($(element).attr('data-cta')) {
                    var oldValue = $(element).attr('href');
                    if (linkSection == '') {
                        $(element).attr('href', '');
                    } 
                    else if (linkSection.indexOf('http') == -1 ) {
                        $(element).attr('href', 'http://'+linkSection);
                        $('[data-change="link"]').val('http://'+linkSection);
                    }
                    else {
                        $(element).attr('href', linkSection);
                    }
                    var newValue = $(element).attr('href', '');
                } 
                else if ($(element).parent('a').attr('data-href')) {
                    var oldValue = $('[data-href]').attr('href');
                    if (linkSection == '') {
                        $('[data-href]').attr('href', '');
                    }
                    else if (linkSection.indexOf('http') == -1 ) {
                        $('[data-href]').attr('href', 'http://'+linkSection);
                        $('[data-change="link"]').val('http://'+linkSection);
                    }
                    else {
                        $('[data-href]').attr('href', linkSection);
                    }
                    var newValue = $('[data-href]').attr('href');
                }
                if (oldValue != newValue) {
                    saveInStack(true);
                }
            }   
        });
    })();
}

// XXI : Récupération/Modification de l'espacement
function paddingObjet(element) {
    let inputTop = '[data-change="padding-top"]';
    let inputRight = '[data-change="padding-right"]';
    let inputBottom = '[data-change="padding-bottom"]';
    let inputLeft = '[data-change="padding-left"]';
    paddingTopSection = parseFloat($(element).css('padding-top'));
    paddingRightSection = parseFloat($(element).css('padding-right'));
    paddingBottomSection = parseFloat($(element).css('padding-bottom'));
    paddingLeftSection = parseFloat($(element).css('padding-left'));
    $(inputTop).val(paddingTopSection).attr('value', paddingTopSection);
    $(inputRight).val(paddingRightSection).attr('value', paddingRightSection);
    $(inputBottom).val(paddingBottomSection).attr('value', paddingBottomSection);
    $(inputLeft).val(paddingLeftSection).attr('value', paddingLeftSection); 

    var array = [inputTop, inputRight, inputBottom, inputLeft];

    for (var i = 0; i < array.length; i++) {
        changeSpinner(array[i], element);
    }
}

// XXII : Récupération/Modification de la taille des bordures
function borderSizeObjet(element) {
    let inputTop = '[data-change="border-top-width"]';
    let inputRight = '[data-change="border-right-width"]';
    let inputBottom = '[data-change="border-bottom-width"]';
    let inputLeft = '[data-change="border-left-width"]';
    borderWidthTopSection = parseFloat($(element).css('border-top-width'));
    borderWidthRightSection = parseFloat($(element).css('border-right-width'));
    borderWidthBottomSection = parseFloat($(element).css('border-bottom-width'));
    borderWidthLeftSection = parseFloat($(element).css('border-left-width'));
    $(inputTop).val(borderWidthTopSection).attr('value', borderWidthTopSection);
    $(inputRight).val(borderWidthRightSection).attr('value', borderWidthRightSection);
    $(inputBottom).val(borderWidthBottomSection).attr('value', borderWidthBottomSection);
    $(inputLeft).val(borderWidthLeftSection).attr('value', borderWidthLeftSection);

    if ($(element).css('border-style') !== 'solid') {
        $(element).css('border-style', 'solid');
        $(element).css('border-width', '0px');
        $(element).css('border-color', '#000');
    }

    var array = [inputTop, inputBottom];

    for (var i = 0; i < array.length; i++) {
        changeSpinner(array[i], element);
    }
}

// XXIII : Récupération/Modification de la couleur des bordures
function borderColorObjet(element) {
    let inputTop = '[data-change="border-top-color"]';
    let inputRight = '[data-change="border-right-color"]';
    let inputBottom = '[data-change="border-bottom-color"]';
    let inputLeft = '[data-change="border-left-color"]';
    borderColorTopSection = rgb2hex($(element).css('border-top-color'));
    borderColorRightSection = rgb2hex($(element).css('border-right-color'));
    borderColorBottomSection = rgb2hex($(element).css('border-bottom-color'));
    borderColorLeftSection = rgb2hex($(element).css('border-left-color'));
    $(inputTop).attr('value', borderColorTopSection).minicolors('value', borderColorTopSection);
    $(inputRight).attr('value', borderColorRightSection).minicolors('value', borderColorRightSection);
    $(inputBottom).attr('value', borderColorBottomSection).minicolors('value', borderColorBottomSection);
    $(inputLeft).attr('value', borderColorLeftSection).minicolors('value', borderColorLeftSection);

    var array = [inputTop, inputBottom];

    for (var i = 0; i < array.length; i++) {
        changeMinicolor(array[i], element);
    }
}

// XXIV : Récupération/Modification du contour des bordures
function borderRadiusObjet (element) {
    let input = '[data-change="border-radius"]';
    borderRadius = parseFloat($(element).css('border-radius'));
    $(input).val(borderRadius).attr('value', borderRadius);

    changeSpinner(input, element);
}

// XXV : Action des différents items à la disparition des items
function hideSidebar() {
    $('.field_item_sidebar').hide();
    $('#storage_email [data-content]').removeClass('activeover');
    $('[data-text], [data-img], [data-cta], [data-spacer]')
    .removeClass('active noactive');
    $('[data-menu], [data-task]').removeClass('active');
    $('[data-menu]#items_sidebar').addClass('active');
    $('[data-task="notask"]').addClass('active');
    $('[data-section]').removeClass('active');
    inEdit = false;
}

// XXVI : Disparition des items
function disappearItem(e) {
    var click =  $(e.target).children();
    if (click.is("[data-content]")){
        hideSidebar();
    }
}

/*----------  Actions  ----------*/

// Démarrage des modules d'édition de texte
$(document).ready(function() {

    /* Création de Medium Editor */
    creatMediumEditor();

    /* Démarre le clic sur les data-txt */
    $(document).on("click", '[data-text], [data-img], [data-cta], [data-spacer]', function(e) {
        inEdit = true;
        stopRedirection(e);
        editSidebar(targetTheTarget(this));

        /* Active / Désactive le hover opacity */
        $('[data-text], [data-img], [data-cta], [data-spacer]').removeClass('active');
        $(this).addClass('active');
        $('[data-section]').removeClass('active');
        $(this).parents('[data-section]').addClass('active');

        $('[data-text], [data-img], [data-cta], [data-spacer]').not('.active').addClass('noactive');
        $(this).removeClass('noactive');
    });

    /* Sauvegarde dans l'historique */
    $(document).click(function(e) {
        if (flagEditor) {
            flagEditor = false;
            saveInStack(true);
        }

        if (flagSpin) {
            var id = flagSpin.attr('data-change');
            if ($(e.target).parents('#'+id).length < 1) {
                saveInStack(true);
                flagSpin = undefined;
            }
        }
    });

    /* Disparition des items */
    $(document).on("click", '#storage_email', function(e) {
        disappearItem(e);
    });
});
/*=============================================
=            Contrôle des sections            =
=============================================*/

/**
    *
    * Librairie : JQuery
        - JS : lib/js/jquery
        - CSS : null
        - Github : https://github.com/jquery/jquery
        - Documentation : http://api.jquery.com/
    * 
    * Librairie : JQuery UI
        - JS : lib/js/jquery-ui
        - CSS : lib/css/jquery-ui
        - Github : https://github.com/jquery/jquery-ui
        - Documentation : http://api.jqueryui.com/
    *
    *
*/

/*----------  Variables  ----------*/

var sectionSelected; // Section séléctionnée
var sectionHeight; // Hauteur de la section séléctionnée
var duplicatedSection // Section clonée
var maxHeight = 0; // Height de la plus grande section
var id_mail; // ID du mail
var sort = false // En cours de mouvement

// Container d'outils de chaque section [table[data-content]]
var tools_section = '<div class="tools_section col">'+
'<span class="item_tools_section" id="moveSection" ><i class="material-icons">open_with</i></span>'+
'<span class="item_tools_section" id="duplicateSection" ><i class="material-icons">content_copy</i></span>'+
'<span class="item_tools_section" id="deleteSection" ><i class="material-icons">delete_sweep</i></span>'+
'</div>';

/*----------  Functions  ----------*/

/**
    Séléctionnez le titre puis CTRL+D (Windows) ou CMD+D (Mac).
    - I     :  Génération d'ID aléatoire 
    - II    :  Attribution d'un ID unique
    - III   :  Récupération des paramètres d'URL
    - IV    :  Insertion des thumbnails
    - V     :  Blocage des redirections des liens
    - VI    :  Génération du draggable des thumbnails
    - VII   :  Génération du sortable des sections
    - VIII  :  Suppression d'une section
    - IX    :  Duplication d'une section
**/

// I : Génération d'un ID unique
function IDGen() {
    id = Math.floor(Math.random() * 16777215).toString(16);
    return id;
};

// II : Attribution d'un ID unique
function newID(section){
    section.find('[data-text]').each(function() {
        $(this).attr('data-text', IDGen());
    });
    section.find('[data-cta]').each(function() {
        $(this).attr('data-cta', IDGen());
    });
    section.find('[data-img]').each(function() {
        $(this).attr('data-img', IDGen());
    });
    section.find('[data-spacer]').each(function() {
        $(this).attr('data-spacer', IDGen());
    });
}

// III : Récupération des paramètres d'URL
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

// IV : Insertion des thumbnails
(function launchThumbs() {
    var sections = $('#storage_template table[data-section]');
    var nbSections = sections.length;
    id_mail = getUrlParameter('id');

    $.ajax({
        type: "POST",
        data: {idMail4Thumbs: id_mail},
        url : "?module=user&action=email_builder",
        success : function(html) {
            var folder = html;
            for (var i = 0; i < nbSections; i++) {
                var the_section = $(sections).eq(i).attr('data-section');
                var thumb = ''+folder+''+the_section+'.png';
                var maxWidth = $('[data-content]').width();
                var block = 
                '<div style="max-width:'+maxWidth+'px;" class="thumbnail" data-thumbnail="'+the_section+'">'+
                '<a href="#" title="">'+
                '<img src="'+thumb+'" alt="" title=""/>'+
                '</a>'+
                '</div>'
                $('[data-task="thumbnails_sidebar"]').append(block);
            }
        }
    });
})();

// V : Blocage des redirections des liens
function stopRedirection(e) {
    e.preventDefault();
    e.stopPropagation();
    return false;
};

// VI : Génération du draggable des thumbnails
function creatDraggable(items) {
    $(items).draggable({
        /* Ajoute les classes par default */
        addClasses : true,
        /* Ou cela doit apparaitre */
        appendTo: 'parent',
        /* Axe de déplacement */
        axis: false,
        /* Ne rien faire si l'utilisateur n'utilise pas l'handle */
        cancel: 'input,textarea,button,select,option',
        /* Insert de nouvelles classes */
        classes: {},
        /* Connexion avec un sortable */
        connectToSortable: '#storage_email',
        /* Contient les éléments dans le container */
        containment: '.container_builder',
        /* Curseur style quand mouvement en fonctionnement */
        cursor: 'move',
        /* Mouvement du curseur max */
        cursorAt: false,
        /* Transition delay */
        delay: 0,
        /* Arret du sortable */
        disabled: false,
        /* Distance (px) (axis) à partir du moment ou le sortable doit bouger */
        distance: 1,
        /* Step by step (px) lorsque l'on se déplace */
        grid: false,
        /* Bouton permettant le mouvement */
        handle: false,
        /* L'item en mouvement */
        helper: "clone",
        /* */
        iframeFix: false,
        /* Opacité pendant le drag */
        opacity: 1,
        /* Calcul la position a chaque mouvement */
        refreshPosition: false,
        /* Anime le retour de l'élément au drop */
        revert: false,
        /* Durée du revert */
        revertDuration: 250,
        /* Autorise le scroll */
        scroll: false,
        /* A partir de combien (px) avant la fin de page pour scroller */
        scrollSensitivity: 100,
        /* Vitesse du scroll */
        scrollSpeed: 20,
        /* Se coller aux éléments*/
        snap: false,
        /* Quel éléments */
        snapMode: 'inner',
        /* Tolérance du snapmode */
        snapTolerance: 20,
        /* Force le z-index supérieur */
        stack: items,
        /* Controle le z-index de l'élément draggé */
        zIndex: false,
        /* Event à la création du module (onready) */
        create: function(event, ui) {},
        /* Event au commencement du drag */
        start: function(event, ui) {},
        /* Event durant le drag */
        drag: function(event, ui) {},
        /* Event à la fin du drag */
        stop: function(event, ui) {}
    });
}

// VII : Génération du sortable des sections
function creatSortable(container) {
    $(container).sortable({
        /* Ou cela doit apparaitre */
        appendTo: 'parent',
        /* Axe de déplacement */
        axis: 'y',
        /* Ne rien faire si l'utilisateur n'utilise pas l'handle */
        cancel: 'input,textarea,button,select,option',
        /* Insert de nouvelles classes */
        classes: {},
        /* Connexion avec d'autres containers */
        connectwith: false,
        /* Contient les éléments dans le container (impossible de les sortir) */
        containment: false,
        /* Curseur style quand mouvement en fonctionnement */
        cursor: 'move',
        /* Mouvement du curseur max */
        cursorAt: { left: 0, top: 0 },
        /* Transition delay */
        delay: 0,
        /* Arret du sortable */
        disabled: false,
        /* Distance (px) (axis) à partir du moment ou le sortable doit bouger */
        distance: 0,
        /* Possibilité de dropper un element dans un container vide */
        dropOnEmpty: true,
        /* Force la création de l'espacement (de l'item) avant de dropper */
        forcePlaceholderSize: true,
        /* Step by step (px) lorsque l'on se déplace */
        grid: [ 1, 1 ],
        /* Bouton de mouvement */
        handle: '#moveSection',
        /* On clone l'item */
        helper: "clone",
        /* Elements pouvant être déplacé */
        items: "> *",
        /* Opacité pendant le drag */
        opacity: 1,
        /* Classe du placeholder */
        placeholder: "sortable-placeholder",
        /* Anime le retour de l'élément au drop */
        revert: false,
        /* Autorise le scroll en fin de page */
        scroll: true,
        /* A partir de combien (px) avant la fin de page pour scroller */
        scrollSensitivity: 100,
        /* Vitesse du scroll */
        scrollSpeed: 20,
        /* Moment pour chevaucher un élément */
        tolerance: "pointer",
        /* Z-index de l'élément dragger */
        zIndex: 9999,
        /* Event drag de n'importe quoi (container même ou autre) */
        activate: function(event, ui){},
        /* Event au lachage mais placeholder encore en activité */
        beforeStop: function(event, ui){},
        /* Event au changement de l'ordre des éléments (durant le drag) */
        change: function(event, ui){},
        /* Event à la création du module (onready) */
        create: function(event, ui){},
        /* Event à la fin du sortable */
        deactivate: function(event, ui){
            $('body').removeAttr('style');
        },
        /* Event lorsqu'un item en mouvement sort du container */
        out: function(event, ui){},
        /* Event lorsqu'un item en mouvement entre dans le container */
        over: function(event, ui){},
        /* Event recoit des éléments d'un autre container */
        receive: function(event, ui){
            var droppedSection = ui.helper.attr('data-thumbnail');
            var newSection = $('#storage_template table[data-section="' + droppedSection + '"]');
            newID(newSection);
            newSection.clone().prependTo("#storage_template");
            ui.helper.replaceWith(function() {
                ui.helper.replaceWith(newSection);
            });
            $(newSection).attr('data-section', IDGen());
            
            $('[data-content]').removeClass('activeover');
            $('[contenteditable]').removeAttr('contenteditable');
            $('[spellcheck]').removeAttr('spellcheck');
            $('[data-medium-editor-element]').removeAttr('data-medium-editor-element');
            $('[data-medium-editor-editor-index]').removeAttr('data-medium-editor-editor-index');
            $('[medium-editor-index]').removeAttr('medium-editor-index');
            $('[data-original-title]').removeAttr('data-original-title');

            creatMediumEditor();
        },
        /* Event lorqu'un item est déplacé dans un autre container */
        remove: function(event, ui) {},
        /* Event durant le mouvement */
        sort: function(event, ui) {
            sort = true;
        },
        /* Event à la création du sort */
        start: function(event, ui){},
        /* Event une fois que le sort est terminé */
        stop: function(event, ui){
            sort = false;
            $('.tools_section').remove();
        },
        /* Event au changement de l'ordre des éléments */
        update: function(event, ui){
            saveInStack();
        },
    });
}

// VIII : Suppression d'une section
function removeSection(targetClic) {
    sectionSelected = $(targetClic).closest('table[data-section]');
    sectionSelected.fadeOut( "slow", function() {
        sectionSelected.remove();
        saveInStack();
    });
}

// IX : Duplication d'une section
function duplicateSection(targetClic) {
    sectionSelected = $(targetClic).closest('table[data-section]');
    duplicatedSection = sectionSelected.clone();
    if ($(sectionSelected).find('.active').length == 1) {
         $(duplicatedSection).find('.active').removeClass('active').addClass('noactive');
    };
   
    $(duplicatedSection).closest('table[data-section]').find('.tools_section').remove();
    duplicatedSection.insertAfter(sectionSelected);

    newID(duplicatedSection);

    reloadMediumEditor();
    
    saveInStack();
}

/*----------  Actions  ----------*/

// Démarrage des modules de contrôle de sections
$(document).ready(function() {
    
    /* Génération du draggable des thumbnails */
    creatDraggable('.thumbnail');

    /* Génération du sortable des sections */
    creatSortable('#storage_email');

    /* Attribution d'un nombre random en ID */
    $('[data-section]').each(function() {
        newID($(this));
    }); 

    /* Blocage des redirections des liens */
    $(document).on('click', '[data-cta], #storage_email a', function(e) {
        stopRedirection(e);
    });

    /* Suppression d'une section */
    $(document).on('click', '#deleteSection', function() {
        removeSection(this);
    });

    /* Duplication d'une section */
    $(document).on('click', '#duplicateSection', function(){
        duplicateSection(this);
    });

    /* Apparition des outils de contrôle */
    $(document).on('mouseenter', '[data-content]', function() {
        if (viewDesktop) {
            if (!sort) {
                $(this).prepend(tools_section);
            }
        }
    });

    /* Disparition des outils de contrôle */
    $(document).on('mouseleave', '#storage_email [data-content]', function()  {
        if (!sort) {
            $(this).find('.tools_section').remove();
        }
    });
});

/*=====  End of Contrôle des sections  ======*/
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
     * Librairie : JQuery UI
        - JS : lib/js/jquery-ui
        - CSS : lib/css/jquery-ui
        - Github : https://github.com/jquery/jquery-ui
        - Documentation : http://api.jqueryui.com/
    *
*/

/*----------  Variables  ----------*/

inEdit = false; // Statut des items du builder

/*----------  Actions  ----------*/

$(document).ready( function() {

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
var datas = ['cta', 'text', 'spacer', 'img'];

// Bout de code pour correction dans de l'app Gmail
var fixGmailApp = '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="center"><table class="container" align="center" width="650" border="0" cellpadding="0" cellspacing="0"><tr><td height="30"><table class="gmapp" align="center" width="650" border="0" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;border:0px;"><tbody><tr><td><div class="gmapp" style="white-space:nowrap; font:15px courier; color:#F4F3F1;">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div></td></tr><tr><td><img class="gmapp" src="images/spacer.png" width="650" height="1" style="min-width:650px;width:650px" border="0" /></td></tr></tbody></table></td></tr></table></td></tr></table>';
/*----------  Functions  ----------*/

/**
    Séléctionnez le titre puis CTRL+D (Windows) ou CMD+D (Mac).
    - I     :  Récupèration des paramètres d'URL 
    - II    :  Récupèration des informations de l'email
    - III   :  Sauvegarde du builder
    - IV    :  Redémarrage de Medium Editor
    - V     :  Action après l'undo/redo
    - VI    :  Capture du DOM dans l'historique des modifications
    - VII   :  Undo
    - VIII  :  Redo
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

// IV : Redémarrage de Medium Editor
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


// V : Action après l'undo/redo
function actionAfterUndoRedo(element){
    if (element) { 
        for (var i = 0; i < datas.length; i++) {
            if (element.getAttribute('data-'+datas[i])) {
                var id = element.getAttribute('data-'+datas[i]);
                var el = document.querySelector('[data-'+datas[i]+'="'+id+'"]');
                el.click();
            }
        }

    } else {
        hideSidebar();
    }
    reloadMediumEditor();
}

// VI : Capture du DOM dans l'historique des modifications
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
        var proto = document.querySelector('[data-target]');
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

// VI : Undo 
function undo() {
    if (positionInArray - 1 >= 0) {
        positionInArray =  positionInArray - 1;
        var lastDOM = h[positionInArray][0];
        var obj = h[positionInArray + 1][1];
        contentToObserve.innerHTML = lastDOM;
        actionAfterUndoRedo(obj);
        buttonsUndoRedo[1].removeAttribute('disabled');
        if (positionInArray == 0) {
            buttonsUndoRedo[0].setAttribute('disabled', 'disabled');
        }
    }
}

// VII : Redo
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

// VIII : Nettoyage des attributs
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

            $(this).css('font-family', fallBackFonts[1]+', '+fallBackFonts[2]+', '+familyName+'');
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

    if (getUrlParameter('action') == 'email_builder') {
        document.body.setAttribute('data-turbolinks', 'false');
    }

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