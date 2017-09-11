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
var flagInEdit;
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
        console.log('medium editor, bold par exemple');
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
                // if ($(element).attr('data-img')) {
                //     if ($(event.target).attr('data-change') == 'height') {
                //         $(element).attr('height', ui.value);
                //     }
                // }
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
                saveInStack(element);
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
                saveInStack();
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
                console.log('save');
                saveInStack();
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
                    console.log('save');
                    saveInStack();
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
    .removeAttr('data-target')
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

    /* Disparition des items */
    $(document).on("click", '#storage_email', function(e) {
        disappearItem(e);
    });

    /* Sauvegarde dans l'historique */
    $(document).click(function(e) {
        if (flagEditor) {
            flagEditor = false;
            saveInStack();
        }

        if (flagSpin) {
            var id = flagSpin.attr('data-change');
            console.log($(e.target));
            if ($(e.target).parents('#'+id).length > 0) {
                console.log('dedans non save');
            } else {
                console.log('save');
                flagSpin = undefined;
            }
        }
    });
});