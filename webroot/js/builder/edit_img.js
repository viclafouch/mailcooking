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