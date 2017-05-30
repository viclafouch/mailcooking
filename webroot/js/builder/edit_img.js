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

var imgToEdit; // L'image à editer
var imgHeight; // Hauteur de l'image
var imgWidth; // Largeur de l'image
var imgAlt; // Attribut alt de l'image
var imgLink; // Attribut href de l'image
var imgEdit; // L'image en cours d'édition
var keys = {37: 1, 38: 1, 39: 1, 40: 1}; // touches directionnelles
var id_mail; // ID du mail 

// Contenu du container [div.edit_img croppie_sleep]
var cropper = '<span class="close" id="closeCroppie"></span><div class="container-fluid col col-hori-center nowrap"><div id="cropperimg"></div><div class="action_img row row-hori-center"><input id="imgAltEdit" type="text" value="" placeholder="Tag alternatif"></div><div class="action_img btns_action row row-hori-center nowrap"><input type="file" id="new_file_img" name="pic" accept=".png, .jpeg, .jpg" /><input type="submit" id="saveCroppie" value="Confirmer"></div>'

/*----------  Functions  ----------*/

/**
    Séléctionnez le titre puis CTRL+D (Windows) ou CMD+D (Mac).
    - I     :  Bloque les évènements 
    - II    :  Bloque évènements (touches clavier)
    - III   :  Désactive Scroll (via I & II);
    - IV    :  Active Scroll
    - V     :  Récupère les paramètres d'URL
    - VI    :  Création du Cropper
    - VII   :  Insertion d'un nouveau fichier
    - VIII  :  Sauvegarde des modifications
    - IX    :  Annule des modifications
    - X     :  Constructeur
**/

// I : Bloque les évènements 
function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault) {
        e.preventDefault();
        e.returnValue = false;
    }  
}

// II : Bloque évènements (touches clavier) 
function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

// III : Désactive Scroll (via I & II);
function disableScroll() {
    if (window.addEventListener) {
        window.addEventListener('DOMMouseScroll', preventDefault, false);
        window.onwheel = preventDefault;
        window.onmousewheel = document.onmousewheel = preventDefault;
        window.ontouchmove  = preventDefault;
        document.onkeydown  = preventDefaultForScrollKeys;
    }
}

// IV : Active Scroll
function enableScroll() {
    if (window.removeEventListener) {
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
        window.onmousewheel = document.onmousewheel = null; 
        window.onwheel = null; 
        window.ontouchmove = null;  
        document.onkeydown = null; 
    }
}

// V : Récupère les paramètres d'URL
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

// VI :  Création du Cropper
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

// VII : Insertion d'un nouveau fichier
var changeCroppie = function(input) {
    $(input).change(function() {
        var file = this.files[0];
         
        /* Verification du poids du fichier inséré */
        if (file.size > 2500000 || file.fileSize > 2500000) {
           alert("Allowed file size exceeded. (Max. 2.5 MB)");
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

// VIII : Sauvegarde des modifications
var saveCroppie = function(input, selection) {
    $(input).on('click', function() {
        $alt = $('#imgAltEdit').val();
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
                }
            });
        });

        $('.croppie_sleep').removeClass('active');

        enableScroll();
    });

    $(document).on('keydown', function(e) {
        if ($('#imgToCroppie').hasClass('active')) {
            switch (e.keyCode) {
            case 13:
                e.preventDefault();
                $(input).trigger('click');
                break;
            };
        };
    });
}

// IX : Annule des modifications
var closeCroppie = function(input) {
    $(input).on('click', function(e){
        e.stopPropagation();
        e.preventDefault();
        $('.croppie_sleep').removeClass('active');
        setTimeout(function(){
            imgEdit.croppie('destroy');
        }, 300);
        enableScroll();
    });
    $(document).on('keydown', function(e) {
        if ($('#imgToCroppie').hasClass('active')) {
            switch (e.keyCode) {
            case 27:
                e.preventDefault();
                $(input).trigger('click');
                break;
            };
        };
    });
}

// X : Constructeur
var imgCropper = function(selection) {

    /* Récupération des infos de l'image séléctionnée */
    imgToEdit   =   selection.attr('src');
    imgAlt      =   selection.attr('alt');
    imgHeight   =   parseFloat(selection.height());
    imgWidth    =   parseFloat(selection.width());

    /* Insertion du contenu HTML */
    $('#imgToCroppie').html(cropper);

    /* Insertion de l'attribut ALT */
    $('#imgAltEdit').val(imgAlt);

    /* Création du croppie de l'image séléctionnée */
    creatCroppie(imgToEdit);

    /* Affichage de la popup */
    $('.croppie_sleep').addClass('active');

    /* Changement de cropper à l'insertion d'un fichier */
    changeCroppie('#new_file_img');

    /* Sauvegarde de l'image dans le serveur */
    saveCroppie('#saveCroppie', selection);

    /* Ferme et annule les modifications d'image */
    closeCroppie('#closeCroppie');
}

/*----------  Actions  ----------*/

// Démarre la modification d'image
$('#active-croppie').bind('click', function() {
    if ($(this).attr('data-tocroppie')) {
        if (!$(this).hasClass('active')) {    
            disableScroll();
            selectedID = $(this).attr('data-tocroppie');
            selectedIMG = $("[data-img='" + selectedID + "']");
            imgCropper(selectedIMG);
        }
    }
});

/*=====  End of Edition d'image  ======*/