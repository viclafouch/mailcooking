# Mailcooking 🐵👓

Bienvenue à bord __jeune padawan__!

![](https://media4.giphy.com/media/10a9ikXNvR9MXe/giphy.gif)

Voici la documentation de Mailcooking. Projet construit par CRMCURVE dont le stagiaire __[Victor de la Fouchardière](http://www.victor-de-la-fouchardiere.fr/ "Victor de la Fouchardière")__ étant en majeur partie développeur de cette l'application PaaS.

## Mailcooking en bref

MailCooking est une plateforme PaaS vous permettant de concevoir et d'éditer vos newsletters en quelques clics et de les programmer sur votre routeur.

*Le contenu ci-dessous peut ne pas être vérifié ou à jour.*

La plateforme est composée de __2 parties__. Une partie "Non connectée" permettant de comprendre ce qu'est Mailcooking, mais ne permet pas d'accéder à l'application en elle-même. L'autre partie concerne donc l'application avec des plans d'abonnements (via [Stripe](https://stripe.com/fr)).

3 plans d'abonnement :
* Le plan TIP à 48€/mo
* Le plan TOP à 72€/mo
* Le plan TIP TOP à 108€/mo

Chaque abonnement se renouvelle chaque mois __sauf__ si l'utilisateur désactive la récurrence dans ses paramètres de compte.

Le site est structuré en __MVC__ (__Modele / Vue / Controller__), très pratique pour les applications web. Pour comprendre comment cela fonctionne. Vous pouvez-vous référer à ce lien [Wikipedia](https://fr.wikipedia.org/wiki/Mod%C3%A8le-vue-contr%C3%B4leur/).

## Version de test

Une version de test est disponible à cette url http://www.vicandtips.fr/mailcooking . L'inscription n'est pas encore fonctionnelle (pas le temps pour la facilité). Du coups voici les logins : victor.dlf@outlook.fr & admin. Amusez-vous !

## API, langages et librairies utilisés

Pour commencer la configuration et l'optimisation de l'application, il est préférable de comprendre les différents __langages__ utilisés pour faire fonctionner Mailcooking :

* __PHP 5.6__
* __Javascript__ (dont l'utilisation du framework jQuery)
* __HTML / CSS__ (SCSS est préférable)

Les différentes __API__ que Mailcooking profite sont : 

* [Stripe](https://stripe.com/fr)

De multiples __librairies__ sont égalements exploitées : 

* [Turbolinks](https://github.com/turbolinks/turbolinks)
* [jQuery UI](http://jqueryui.com/)
* [HTML2Canvas](https://html2canvas.hertzen.com/)
* [jQuery Minicolors](https://labs.abeautifulsite.net/jquery-minicolors/)
* [Croppie](https://github.com/foliotek/croppie)
* [Medium Editor](https://github.com/yabwe/medium-editor)
* [Undo manager](https://github.com/ArthurClemens/Javascript-Undo-Manager)

Pour ce qui est la __base de données__, l'application gère cela avec __PHPMyAdmin__, une application Web de gestion pour les systèmes de gestion de base de données MySQL réalisée en PHP.

### Installation

Tout d'abord et pour commencer, une plate-forme de développement Web est obligatoire (ou pas dans certains cas), je vous conseille d'y installer [Wamp](http://www.wampserver.com/) pour Windows ou [MAMP](https://www.mamp.info/de/) pour OS X.

Ensuite, il va vous falloir être muni de l'__invite de commande__, ou d'un __émulateur__ (je peux vous conseiller [Cmder](http://cmder.net/)). Quelques lignes de commandes vont être nécessaires pour le bon fonctionnement de Mailcooking. 

[Composer](https://getcomposer.org/) est nécessaire pour faire appel aux differents paquets (comme [Stripe PHP](https://github.com/stripe/stripe-php)). Vous devez donc l'installer sur votre système.

Une fois que avez cloné le dossier sur votre serveur local, munissez-vous de votre terminal et placez-vous sur le dossier mailcooking. __Téléchargez ensuite les paquets__ via __Composer__ : 

```
Composer install
```

Pour ce qui est de Gulp, car oui, le site est entièrement automatisé via Gulp (minification / optimisation / compression / concaténation / compilation et autres mots en tion). Munissez-vous de votre terminal et tapez la commande suivante : 

```
npm install
```

Si tout s'est bien passé durant l'installation des paquets de Gulp, démarrez-le à l'aide de la commande suivante : 

```
gulp
```

Si erreur, me contacter. Je pense qu'un paquet doit s'installer sur votre ordinateur complet, mais je ne sais plus lequel.

Durant votre optimisation, des envoie d'emails vont être nécessaire. Assurez-vous donc d'avoir un __serveur mail opérationnel__. 
Pour Mac, tout est déjà installé dans votre serveur local __Mamp__ (il y a peut etre des paramètres à changer...). Pour les Windowsiens, il existe __sendMail__, je vous laisse donc suivre [ce petit tutoriel](https://www.grafikart.fr/blog/mail-local-wamp) pour l'installation de l'application.

Et voilà, vous êtes prêt pour optimiser Mailcooking, n'oubliez d'y __inclure la base de données__ ;)

### Configurations

Un fichier de configuration est disponible dans app/config/config.inc.php permettant de modifier un abonnement, un chemin de dossier ou encore les clés de Stripe.

### Stripe

Les paiements récurrents se font via l'API Stripe dont le site est : https://stripe.com/fr
* __Login__ : crmcurve@gmail.com
* __Mot de passe__ : Mailcooking&1234

Les __clefs publiques & privées__ du site sont des clefs de test. Il ne faudra donc pas oublier de les changer lorsque Mailcooking sera finalisé. 

Les clefs sont : 

```php
$stripeKeys = array(
  "secret_key"      => 'sk_test_PS2zQTpRTNObBqwvbCkMtC8p',
  "publishable_key" => 'pk_test_jdtjz4b05ADqlx5k093fsmgK'
);

\Stripe\Stripe::setApiKey($stripeKeys['secret_key']);
```

Elles peuvent être également trouvées sur [API Keys - Stripe Dashboard](https://dashboard.stripe.com/account/apikeys)

### Aides fournies

Evidemment que je ne vais pas vous laisser un code sans commentaire ! :p 

![](https://media.giphy.com/media/gw3MYmhxEv8T52ow/giphy.gif)

Chaque controller est commenté de A à Z, mais un minimum de connaissances en PHP est requis (sinon ce serait trop simple). Pour ce qui est de la plus grosse partie du développement, je veux bien entendu parler du builder, les scripts sont découpés en fonction de leur utilité.

Vous pouvez me contacter par __tel ou par mail__ (JC & Antoine ont mes coordonnées). __#noSkype__

## Versioning

La version finalisée par Victor de la Fouchardière se trouve ici : https://github.com/viclafouch/mailcooking/releases/tag/v1.1

## Conclusion

![](http://ljdchost.com/L8am6Ta.gif)
