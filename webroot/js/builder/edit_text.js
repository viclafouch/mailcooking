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
    - X     :  Spinner +/- des items
    - XI    :  Récupération/Modification de l'alignement
    - XII   :  Récupération/Modification de la taille de texte
    - XIII  :  Récupération/Modification de la couleur de texte
    - XIV   :  Récupération/Modification de la couleur de fond
    - XV    :  Récupération/Modification de la police de texte
    - XVI   :  Récupération/Modification de l'interlignage
    - XVII  :  Récupération/Modification de la hauteur
    - XVIII :  Récupération/Modification du lien de redirection
    - XIX   :  Récupération/Modification de l'espacement
    - XX    :  Récupération/Modification de la taille des bordures
    - XXI   :  Récupération/Modification de la couleur des bordures
    - XXII  :  Récupération/Modification du contour des bordures
    - XXIII :  Disparition des items
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
    lineText(element);
    paddingObjet(element);
    borderSizeObjet(element);
    borderColorObjet(element);
}

// VI : Cible == Img
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
    borderRadiusObjet(element);
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
    $('.field_item_sidebar').hide();
    $("[data-menu]#items_sidebar").trigger( "click" );

    if ($(element).attr('data-text')) { clicToText(element) }
    else if ($(element).attr('data-img')) { clicToImg(element) }
    else if ($(element).attr('data-cta')) { clicToCta(element) }
    else if ($(element).attr('data-spacer')) { clicToSpacer(element) }
}

// X : Spinner +/- des items
function changeSpinner(element, change) {
    let input = $('[data-change="'+change+'"]');
    let style = change;

    if ($(element).attr('data-img')) {
       $('[data-change="height"]')
            .attr('data-max', '700')
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
                if ($(element).attr('data-img')) {
                    if ($(event.target).attr('data-change') == 'height') {
                        $(element).attr('height', ui.value);
                    }
                }
            },
            change: function(event, ui) {
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
            }  
        });   
    });
}

// XI : Récupération/Modification de l'alignement
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

// XII : Récupération/Modification de la taille de texte
function sizeText(element) {
    
    sizeSection = parseFloat($(element).css('font-size'));
    $('[data-change="font-size"]').val(sizeSection).attr('value', sizeSection);

    changeSpinner(element, 'font-size');
}

// XIII : Récupération/Modification de la couleur de texte
function colorText(element) {
    let input = $('[data-change="color"]');
    colorSection = rgb2hex($(element).css('color'));
    input.attr('value', colorSection).val(colorSection).minicolors('value',colorSection);

    (function change(){
        $(document).on('change', '[data-change="color"]', function(){
            colorSection = $(this).val();
            $(element).css('color', colorSection);
        });
    })();
}

// XIV : Récupération/Modification de la couleur de fond
function backgroundText(element) {
    let input = $('[data-change="background-color"]');
    backgroundSection = rgb2hex($(element).css('background-color'));
    input.attr('value', backgroundSection).val(backgroundSection).minicolors('value',backgroundSection);

    (function change(){
        $(document).on('change', '[data-change="background-color"]', function(){
            backgroundSection = $(this).val();
            $(element).css('background-color', backgroundSection);
        });
        $(document).on('blur', '[data-change="background-color"]', function(){
            if ($(this).val() == '') {
                input.attr('value', backgroundSection).val(backgroundSection).minicolors('value',backgroundSection);
            }
        });
    })();
}

// XV : Récupération/Modification de la police de texte
function familyText(element) {
    let input = $('[data-change="font-family"]');
    familySection = $(element).css('font-family').split(', ');
    newFamilySection = familySection[0].replace('"', '').replace('"', '');
    input.find('option').removeAttr('selected');
    input.find('#'+newFamilySection).attr('selected', 'true');
    input.val(newFamilySection);

    (function change() {
        $(document).on('change', '[data-change="font-family"]', function() {
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

// XVI : Récupération/Modification de l'interlignage
function lineText(element) {
   
    let input = $('[data-change="line-height"]');
    lineSection = parseFloat($(element).css('line-height'));
    sizeSection = parseFloat($(element).css('font-size'));

    if (!lineSection) {
        input.val(sizeSection * 1.5).attr('value', sizeSection * 1.5);
    }
    else {
        input.val(lineSection).attr('value', lineSection);
    }

    input.attr('data-min', sizeSection);
    input.attr('data-max', sizeSection * 3);
    input.attr('aria-valuemin', sizeSection);
    input.attr('aria-valuemax', sizeSection * 3);

    changeSpinner(element, 'line-height');
}

// XVII : Récupération/Modification de la hauteur
function heightObjet (element) {
    height = parseFloat($(element).attr('height'));
    $('[data-change="height"]').val(height).attr('value', height);

    changeSpinner(element, 'height');
}

// XVIII : Récupération/Modification du lien de redirection
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
        $(document).on('change', '[data-change="link"]', function(){
            linkSection = $(this).val();
            if ($(element).attr('data-cta')) {
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
            } 
            else if ($(element).parent('a').attr('data-href')) {
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
            }            
        });
    })();
}

// XIX : Récupération/Modification de l'espacement
function paddingObjet(element) {
    paddingTopSection = parseFloat($(element).css('padding-top'));
    paddingRightSection = parseFloat($(element).css('padding-right'));
    paddingBottomSection = parseFloat($(element).css('padding-bottom'));
    paddingLeftSection = parseFloat($(element).css('padding-left'));
    $('[data-change="padding-top"]').val(paddingTopSection).attr('value', paddingTopSection);
    $('[data-change="padding-right"]').val(paddingRightSection).attr('value', paddingRightSection);
    $('[data-change="padding-bottom"]').val(paddingBottomSection).attr('value', paddingBottomSection);
    $('[data-change="padding-left"]').val(paddingLeftSection).attr('value', paddingLeftSection); 

    changeSpinner(element, 'padding-top');
    changeSpinner(element, 'padding-bottom');
    changeSpinner(element, 'padding-left');
    changeSpinner(element, 'padding-right');
}

// XX : Récupération/Modification de la taille des bordures
function borderSizeObjet(element) {
    borderWidthTopSection = parseFloat($(element).css('border-top-width'));
    borderWidthRightSection = parseFloat($(element).css('border-right-width'));
    borderWidthBottomSection = parseFloat($(element).css('border-bottom-width'));
    borderWidthLeftSection = parseFloat($(element).css('border-left-width'));
    $('[data-change="border-top-width"]').val(borderWidthTopSection).attr('value', borderWidthTopSection);
    $('[data-change="border-right-width"]').val(borderWidthRightSection).attr('value', borderWidthRightSection);
    $('[data-change="border-bottom-width"]').val(borderWidthBottomSection).attr('value', borderWidthBottomSection);
    $('[data-change="border-left-width"]').val(borderWidthLeftSection).attr('value', borderWidthLeftSection);

    if ($(element).css('border-style') !== 'solid') {
        $(element).css('border-style', 'solid');
        $(element).css('border-width', '0px');
        $(element).css('border-color', '#000');
    }
    changeSpinner(element, 'border-top-width');
    changeSpinner(element, 'border-bottom-width');
}

// XXI : Récupération/Modification de la couleur des bordures
function borderColorObjet(element) {
    borderColorTopSection = rgb2hex($(element).css('border-top-color'));
    borderColorRightSection = rgb2hex($(element).css('border-right-color'));
    borderColorBottomSection = rgb2hex($(element).css('border-bottom-color'));
    borderColorLeftSection = rgb2hex($(element).css('border-left-color'));
    $('[data-change="border-top-color"]').attr('value', borderColorTopSection).minicolors('value', borderColorTopSection);
    $('[data-change="border-top-right"]').attr('value', borderColorRightSection).minicolors('value', borderColorRightSection);
    $('[data-change="border-top-bottom"]').attr('value', borderColorBottomSection).minicolors('value', borderColorBottomSection);
    $('[data-change="border-top-left"]').attr('value', borderColorLeftSection).minicolors('value', borderColorLeftSection);

    (function change(){
        $(document).on('change', '#border input.minicolors-input', function() {
            input = $(this);
            val = input.val();
            $(element).css(input.attr('data-change'), val);
        });
        $(document).on('blur', '#border input.minicolors-input', function(){
            if (input.val() == '') {
                input.attr('value', val).val(val).minicolors('value',val);
            }
        });
    })();
}

// Récupération/Modification du contour des bordures
function borderRadiusObjet (element) {
    let input = $('[data-change="border-radius"]');
    borderRadius = parseFloat($(element).css('border-radius'));
    input.val(borderRadius).attr('value', borderRadius);

    changeSpinner(element, 'border-radius');
}


// XXIII : Disparition des items
function disappearItem(e) {
    var click =  $(e.target).children();
    if (click.is("[data-content]")){
        $('.field_item_sidebar').hide();
        $('#storage_email [data-content]').removeClass('activeover');
        $('[data-text], [data-img], [data-cta], [data-spacer]')
        .removeAttr('data-target')
        .removeClass('active noactive');
        $('[data-menu], [data-task]').removeClass('active');
        $('[data-menu]#items_sidebar').addClass('active');
        $('[data-task="notask"]').addClass('active');
        $('[data-section]').removeClass('active');
        inEdit = false;
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

    /* Disparition des items */
    $(document).on("click", '#storage_email', function(e) {
        disappearItem(e);
    });
});