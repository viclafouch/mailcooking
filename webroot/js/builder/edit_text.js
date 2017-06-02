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
var target; // Cible à modifier
var parent; // Parent Cible
var parentLink; // Parent direct href de l'objet

var val; // Valeur en cours d'insertion
var max; // Valeur max à insérer
var min; // Valeur min à insérer

// Les polices websave
var webSaveFonts = ['Arial','Andale Mono','Arial Black','Bitstream Vera Sans','Courier','Courier New','DejaVu Serif','DejaVu Sans Mono','Georgia','Geneva','Helvetica','Impact','Kalimati','Liberation Sans','Liberation Mono','Lucida Console','FreeSans','FreeMono','Times New Roman', 'Times','Trebuchet MS','FreeSerif', 'Liberation Serif','Lucida Sans','Lucida Grande','Lucida Sans Unicode','Luxi Sans','monospace','Monaco','Norasi','serif', 'sans-serif','Verdana','Tahoma'];

/*----------  Functions  ----------*/

/**
    Séléctionnez le titre puis CTRL+D (Windows) ou CMD+D (Mac).
    - I     :  Création de Medium Editor 
    - II    :  Transformation d'un rgb en hex
    - III   :  Concentration des données modifiées vers la cible
    - IV    :  Concentration des données modifiées vers le parent cible
    - V     :  Cible == Text
    - VI    :  Cible == Img
    - VII   :  Cible == Cta
    - VIII  :  Cible == Spacer
    - IX    :  Affichage des items selon le clic
    - X     :  Récupération/Modification de l'alignement
    - XI    :  Récupération/Modification de la taille de texte
    - XII   :  Récupération/Modification de la couleur de texte
    - XIII  :  Récupération/Modification de la couleur de fond
    - XIV   :  Récupération/Modification de la police de texte
    - XV    :  Récupération/Modification de la hauteur
    - XVI   :  Récupération/Modification du lien de redirection
    - XVII  :  Récupération/Modification de l'espacement
    - XVIII :  Récupération/Modification de la taille des bordures
    - XIX   :  Récupération/Modification de la couleur des bordures
    - XX    :  Disparition des items
**/

// I : Création de Medium Editor
var creatMediumEditor = function() {
    new MediumEditor('[data-text], [data-cta]', {
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
    });
}

// II : Transformation d'un rgb en hex
function rgb2hex(rgb){
    rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
    return (rgb && rgb.length === 4) ? "#" +
    ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
    ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
    ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
}

// III : Concentration des données modifiées vers la cible
function targetTheTarget(element) {
    $('[data-text], [data-img], [data-cta], [data-spacer]').removeAttr('data-target');
    $('[data-content]').removeAttr('data-parent-target');
    $('[data-content] a').removeAttr('data-href');
    $(element).attr('data-target', 'true');
    target = $('[data-target]');
    return target;
}

// IV : Concentration des données modifiées vers le parent cible
function targetTheTargetParent(element) {
    $(element).parents('[data-content]').attr('data-parent-target', 'true');
    parent = '[data-parent-target]';
    return parent;
}

// V : Cible == Text
function clicToText(element) {
    $('[data-display-text]').show();
    alignmentText(element);
    sizeText(element);
    colorText(element);
    backgroundText(targetTheTargetParent(element));
    familyText(element);
    paddingObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
}

// VI : Cible == Img
function clicToImg(element) {
    $(element).removeAttr('border');
    $('[data-display-img]').show();
    linkObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
    dataImg = $(element).attr('data-img');
    $('#active-croppie').attr('data-tocroppie', dataImg);
}

// VII : Cible == Cta
function clicToCta(element) {
    $('[data-display-cta]').show();
    sizeText(element);
    colorText(element);
    backgroundText(element);
    familyText(element);
    linkObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
}

// VIII : Cible == Spacer
function clicToSpacer(element) {
    $('[data-display-spacer]').show();
    backgroundText(element);
    heightObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
}

// IX : Affichage des items selon le clic
function editSidebar(element) {
    element = '[data-target]';
    $('#sections_builder').removeClass('active');
    $('#items_builder').addClass('active');

    $('.sections_builder_block').removeClass('menuactive');
    $('.items_builder_block').addClass('menuactive');

    $('.field_tools_item_block').hide()

    if ($(element).attr('data-text')) { clicToText(element) }
    else if ($(element).attr('data-img')) { clicToImg(element) }
    else if ($(element).attr('data-cta')) { clicToCta(element) }
    else if ($(element).attr('data-spacer')) { clicToSpacer(element) }
}

// X : Récupération/Modification de l'alignement
function alignmentText(element) {
    alignmentSection = $(element).css('text-align');
    $('.format_align').removeClass('active');
    $('#'+alignmentSection+'').addClass('active');

    (function change(){
        $(document).on('click', '.format_align', function(){
            $('.format_align').removeClass('active');
            $(this).addClass('active');
            alignmentSection = $(this).attr('id');
            $(element).css('text-align', alignmentSection);
        });
    })();
}

// XI : Récupération/Modification de la taille de texte
function sizeText(element) {
    sizeSection = parseFloat($(element).css('font-size'));
    $('.font-size').find('input').val(sizeSection).attr('value', sizeSection);

    (function change(){
        $(document).on('change', '.font-size input', function(){
            max = parseFloat($(this).attr('data-max'));
            min = parseFloat($(this).attr('data-min'));
            val = $(this).val();

            if (val == '') {
                $(element).css('font-size', parseFloat($(element).css('font-size'))+'px');
                $(this).attr('value', parseFloat($(element).css('font-size'))).val(parseFloat($(element).css('font-size')));
            }
            else if (val < min) {
                $(element).css('font-size', min+'px');
                $(this).attr('value', min).val(min);
            }
            else if (val > max) {
                $(element).css('font-size', max+'px');
                $(this).attr('value', max).val(max);
            }
            else {
                $(element).css('font-size', val+'px');
                $(this).attr('value', val);
            }      
        });
    })();
}

// XII : Récupération/Modification de la couleur de texte
function colorText(element) {
    let input = $('.color').find('input.choose_color');
    colorSection = rgb2hex($(element).css('color'));
    input.attr('value', colorSection).val(colorSection).minicolors('value',colorSection);

    (function change(){
        $(document).on('change', '.color .choose_color', function(){
            colorSection = $(this).val();
            $(element).css('color', colorSection);
        });
    })();
}

// XIII : Récupération/Modification de la couleur de fond
function backgroundText(element) {
    let input = $('.background-color').find('input.choose_color');
    backgroundSection = rgb2hex($(element).css('background-color'));
    input.attr('value', backgroundSection).val(backgroundSection).minicolors('value',backgroundSection);

    (function change(){
        $(document).on('change', '.background-color .choose_color', function(){
            backgroundSection = $(this).val();
            $(element).css('background-color', backgroundSection);
        });
        $(document).on('blur', '.background-color .choose_color', function(){
            if ($(this).val() == '') {
                input.attr('value', backgroundSection).val(backgroundSection).minicolors('value',backgroundSection);
            }
        });
    })();
}

// XIV : Récupération/Modification de la police de texte
function familyText(element) {
    let input = $('.font-family').find('select');
    familySection = $(element).css('font-family').split(', ');
    newFamilySection = familySection[0].replace('"', '').replace('"', '');
    input.find('option').removeAttr('selected');
    input.find('#'+newFamilySection).attr('selected', 'true');
    input.val(newFamilySection);

    (function change() {
        $(document).on('change', '.font-family select', function() {
            input = $(this);
            val = input.val();
            if (webSaveFonts.includes(val)) {
                $(element).css('font-family', val);
            } else {
                 $(element).css('font-family', val+", Arial, sans-serif");
            }
            $(element).attr('style', $(element).attr('style').replace('"', "'").replace('"', "'"));
        });
    })();
}

// XV : Récupération/Modification de la hauteur
function heightObjet (element) {
    let input = $('.height').find('input.change_value');
    height = parseFloat($(element).attr('height'));
    input.val(height).attr('value', height);

    (function change() {
        $(document).on('change', '.height input.change_value', function(input) {
            targetStyle = $(this).attr('data-change');

            max = parseFloat($(this).attr('data-max'));
            min = parseFloat($(this).attr('data-min'));
            val = $(this).val();

            if (val == '') {
                $(element).attr(targetStyle, parseFloat($(element).attr(targetStyle)));
                $(this).attr('value', parseFloat($(element).attr(targetStyle))).val(parseFloat($(element).css($(this).attr('data-change'))));
            }
            else if (val > max) {
                $(element).attr(targetStyle, max);
                $(this).attr('value', max).val(max);
            }
            else if (val < min || val == '') {
                $(element).attr(targetStyle, min);
                $(this).attr('value', min).val(min);
            }
            else {
                $(element).attr(targetStyle, val);
                $(this).attr('value', val);
            }
        });
    })();
}

// XVI : Récupération/Modification du lien de redirection
function linkObjet(element){
    let input = $('.link').find('input');
    parentLink = $(element).parent('a')[0];
    if (parentLink !== undefined) {
        $(parentLink).attr('data-href', 'true');
        linkSection = $('[data-href]').attr('href');
        input.val(linkSection).attr('value', linkSection);
    }
    else {
        if ($(element).attr('data-cta')) {
            linkSection = $(element).attr('href');
            input.val(linkSection).attr('value', linkSection);
        } else {
            linkSection = '';
            input.val(linkSection).attr('value', linkSection);
        }
    }

    (function change(){
        $(document).on('change', '.link input', function(){
            linkSection = $(this).val();
            if ($(element).attr('data-cta')) {
                $(element).attr('href', linkSection);
            } 
            else {
                if (linkSection == '') {
                    $(element).unwrap('a');
                } 
                else {
                    if ($(element).parent('a')[0] == undefined) {
                        $(element).wrap('<a href="'+linkSection+'" title="" target="_blank"></a>')
                    }
                    else {
                        element = $(element).parent('a');
                        $(element).attr('href', linkSection);
                    }
                }
            }            
        });
    })();
}

// XVII : Récupération/Modification de l'espacement
function paddingObjet(element) {
    paddingTopSection = parseFloat($(element).css('padding-top'));
    paddingRightSection = parseFloat($(element).css('padding-right'));
    paddingBottomSection = parseFloat($(element).css('padding-bottom'));
    paddingLeftSection = parseFloat($(element).css('padding-left'));
    $('.padding').find('#padding-top input').val(paddingTopSection).attr('value', paddingTopSection);
    $('.padding').find('#padding-right input').val(paddingRightSection).attr('value', paddingRightSection);
    $('.padding').find('#padding-bottom input').val(paddingBottomSection).attr('value', paddingBottomSection);
    $('.padding').find('#padding-left input').val(paddingLeftSection).attr('value', paddingLeftSection); 

    (function change(){
        $(document).on('change', '.padding input', function(){
            max = parseFloat($(this).attr('data-max'));
            min = parseFloat($(this).attr('data-min'));
            val = $(this).val();

            if (val == '') {
                $(element).css($(this).attr('data-change'), parseFloat($(element).css($(this).attr('data-change'))));
                $(this).attr('value', parseFloat($(element).css($(this).attr('data-change')))).val(parseFloat($(element).css($(this).attr('data-change'))));
            }
            else if (val > max) {
                $(element).css($(this).parents('.block').attr('id'), max+'px');
                $(this).attr('value', max).val(max);
            }
            else if (val < min || val == '') {
                $(element).css($(this).parents('.block').attr('id'), min+'px');
                $(this).attr('value', min).val(min);
            }
            else {
                $(element).css($(this).parents('.block').attr('id'), val+'px');
                $(this).attr('value', val);
            }
        });
    })();
}

// XVIII : Récupération/Modification de la taille des bordures
function borderSizeObjet(element) {
    borderSizeTopSection = parseFloat($(element).css('border-top-width'));
    borderSizeRightSection = parseFloat($(element).css('border-right-width'));
    borderSizeBottomSection = parseFloat($(element).css('border-bottom-width'));
    borderSizeLeftSection = parseFloat($(element).css('border-left-width'));
    $('.border').find('#border-top input.change_value').val(borderSizeTopSection).attr('value', borderSizeTopSection);
    $('.border').find('#border-right input.change_value').val(borderSizeRightSection).attr('value', borderSizeRightSection);
    $('.border').find('#border-bottom input.change_value').val(borderSizeBottomSection).attr('value', borderSizeBottomSection);
    $('.border').find('#border-left input.change_value').val(borderSizeLeftSection).attr('value', borderSizeLeftSection);

    if ($(element).css('border-style') !== 'solid') {
        $(element).css('border-style', 'solid');
        $(element).css('border-width', '0px');
        $(element).css('border-color', '#000');
    }

    (function change(){
        $(document).on('change', '.border input.change_value', function(){
            max = parseFloat($(this).attr('data-max'));
            min = parseFloat($(this).attr('data-min'));
            val = $(this).val();
            
            if (val == '') {
                $(element).css($(this).attr('data-change'), parseFloat($(element).css($(this).attr('data-change'))));
                $(this).attr('value', parseFloat($(element).css($(this).attr('data-change')))).val(parseFloat($(element).css($(this).attr('data-change'))));
            }
            else if (val > max) {
                $(element).css($(this).parents('.block').attr('id')+'-width', max+'px');
                $(this).attr('value', max).val(max);
            }
            else if (val < min || val == '') {
                $(element).css($(this).parents('.block').attr('id')+'-width', min+'px');
                $(this).attr('value', min).val(min);
            }
            else {
                $(element).css($(this).parents('.block').attr('id')+'-width', val+'px');
                $(this).attr('value', val);
            }
        });
    })();
}

// XIX : Récupération/Modification de la couleur des bordures
function borderColorObjet(element) {
    borderColorTopSection = rgb2hex($(element).css('border-top-color'));
    borderColorRightSection = rgb2hex($(element).css('border-right-color'));
    borderColorBottomSection = rgb2hex($(element).css('border-bottom-color'));
    borderColorLeftSection = rgb2hex($(element).css('border-left-color'));
    $('.border').find('#border-top input.minicolors-input').attr('value', borderColorTopSection).minicolors('value', borderColorTopSection);
    $('.border').find('#border-right input.minicolors-input').attr('value', borderColorRightSection).minicolors('value', borderColorRightSection);
    $('.border').find('#border-bottom input.minicolors-input').attr('value', borderColorBottomSection).minicolors('value', borderColorBottomSection);
    $('.border').find('#border-left input.minicolors-input').attr('value', borderColorLeftSection).minicolors('value', borderColorLeftSection);

    (function change(){
        $(document).on('change', '.border input.minicolors-input', function() {
            input = $(this);
            val = input.val();
            $(element).css(input.parents('.block').attr('id')+'-color', val);
        });
        $(document).on('blur', '.border input.minicolors-input', function(){
            if (input.val() == '') {
                input.attr('value', val).val(val).minicolors('value',val);
            }
        });
    })();
}

// XX : Disparition des items
function disappearItem(e) {
    var click =  $(e.target).children();
    if (click.is("[data-content]")){
       $('.field_tools_item_block').hide();
        $('#storage_email [data-content]').removeClass('activeover');
        $('[data-text], [data-img], [data-cta]').removeAttr('data-target');
    }
}

/*----------  Actions  ----------*/

// Démarrage des modules d'édition de texte
$(document).ready(function() {

    $('.choose_color').minicolors();
    $('.choose_color_border').minicolors();

    $('.field_tools_item_block').hide();

    /* Création de Medium Editor */
    creatMediumEditor();

    /* Démarre le clic sur les data-txt */
    $(document).on("click", '[data-text], [data-img], [data-cta], [data-spacer]', function(e) {
        stopRedirection(e);
        editSidebar(targetTheTarget(this));
    });

    /* Disparition des items */
    $(document).on("click", '#storage_email', function(e) {
        disappearItem(e);
    });
});