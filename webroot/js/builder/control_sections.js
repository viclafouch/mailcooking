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
    - VIII  :  Ajout d'un espacement en fin de l'email
    - IX    :  Suppression d'une section
    - X     :  Duplication d'une section
**/

// I : Génération d'un ID unique
function IDGen() {
    id = Math.floor(Math.random() * 16777215).toString(16);
    return id;
};

// II : Attribution d'un ID unique
function newID(section){
    section.find('[data-text]').attr('data-text', IDGen());
    section.find('[data-cta]').attr('data-cta', IDGen());
    section.find('[data-img]').attr('data-img', IDGen());
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
                var block = 
                '<div class="thumbnail" data-thumbnail="'+the_section+'">'+
                '<a href="#" title="">'+
                '<img src="'+thumb+'" alt="" title=""/>'+
                '</a>'+
                '</div>'
                $( "#thumbs" ).append(block);
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
        opacity: 0.90,
        /* Calcul la position a chaque mouvement */
        refreshPosition: true,
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
        stop: function(event, ui) {
            $('.content_email').css('position', 'relative');
        }
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
        opacity: 0.90,
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
            sectionHeight = newSection.height();
            $('#storage_email').height($('#storage_email').height()+sectionHeight+"px");
        },
        /* Event lorqu'un item est déplacé dans un autre container */
        remove: function(event, ui) {},
        /* Event durant le mouvement */
        sort: function(event, ui) {
            sort = true;
            var offset = $("#storage_email").height();
            if($('.content_email').scrollTop() > offset){
               $( "#storage_email" ).sortable( "option", "scroll", false );
            }
            else {
                $( "#storage_email" ).sortable( "option", "scroll", true );
            }
        },
        /* Event à la création du sort */
        start: function(event, ui){},
        /* Event une fois que le sort est terminé */
        stop: function(event, ui){
            sort = false;
            $('.tools_section').remove();
            $('.content_email').css('position', 'relative');
        },
        /* Event au changement de l'ordre des éléments */
        update: function(event, ui){
            saveInStack(createId(), $('#storage_email').html());
        },
    });
}

// VIII : Ajout d'un espacement en fin de l'email
(function upHsize(){
    $("[data-section]").each(function(){
       var thisH = $(this).height();
       if (thisH > maxHeight) { maxHeight = thisH; }
    });

    x = $('#storage_email').height()+maxHeight+"px";
    $('#storage_email').height(x);
})();

// IX : Suppression d'une section
function removeSection(targetClic) {
    sectionSelected = $(targetClic).closest('table[data-section]');
    sectionHeight = sectionSelected.height();
    $('#storage_email').height($('#storage_email').height()-sectionHeight+"px");
    sectionSelected.fadeOut( "slow", function() {
        sectionSelected.remove();
    });
    saveInStack(createId(), $('#sortable').html());
}

// X : Duplication d'une section
function duplicateSection(targetClic) {
    sectionSelected = $(targetClic).closest('table[data-section]');
    duplicatedSection = sectionSelected.clone();
    $(duplicatedSection).closest('table[data-section]').find('.tools_section').remove();
    duplicatedSection.insertAfter(sectionSelected);

    newID(duplicatedSection);

    $('[data-content]').removeClass('activeover');
    $('[contenteditable]').removeAttr('contenteditable');
    $('[spellcheck]').removeAttr('spellcheck');
    $('[data-medium-editor-element]').removeAttr('data-medium-editor-element');
    $('[data-medium-editor-editor-index]').removeAttr('data-medium-editor-editor-index');
    $('[medium-editor-index]').removeAttr('medium-editor-index');
    $('[data-original-title]').removeAttr('data-original-title');

    creatMediumEditor();
    
    sectionHeight = sectionSelected.height();
    $('#storage_email').height($('#storage_email').height()+sectionHeight+"px");

    saveInStack(createId(), $('#sortable').html());
}

/*----------  Actions  ----------*/

// Démarrage des modules de contrôle de sections
$(document).ready(function() {
    creatDraggable('.thumbnail');
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
    $(document).on('mouseenter', '#storage_email [data-content]', function() {
        if (!sort) {
            $(this).prepend(tools_section);
        }
    });

    /* Disparition des outils de contrôle */
    $(document).on('mouseleave', '#storage_email [data-content]', function()  {
        if (!sort) {
            $(this).find('.tools_section').remove();
        }
    });

    /* Préparation du style pour le drag */
    $(document).on('mouseenter', '#thumbs', function()  {
        $('.content_email').css('position', 'static');
    });
});

/*=====  End of Contrôle des sections  ======*/