# Mailcooking

Bienvenue à bord jeune padawan !

![](https://media4.giphy.com/media/10a9ikXNvR9MXe/giphy.gif)

Voici la documentation de Mailcooking. Projet construit par CRMCURVE dont le stagiaire [Victor de la Fouchardière](https://github.com/upstage/ "Victor de la Fouchardière") étant en majeur partie contribuer à cette l'application PaaS.

## Mailcooking en bref

MailCooking est une plateforme PaaS vous permetant de concevoir et éditer vos newsletters en quelques clics et de les programmer sur votre routeurs.

*Le contenu ci-dessous peut ne pas être vérifié ou à jour.*

La plateforme est composée de 2 partie. Une partie "Non connectée" permettant de comprendre ce qu'est Mailcooking, mais ne permet pas d'accéder à l'application en elle-même. L'autre partie concerne donc l'application avec des plans d'abonnements (via [Stripe](https://stripe.com/fr)).

3 plans d'abonnement :
* Le plan TIP à 48€/mo
* Le plan TOP à 72€/mo
* Le plan TIP TOP à 108€/mo

Chaque abonnement se renouvelle chaque mois __sauf__ si l'utilisateur désactive la récurrence dans ses paramètres de compte.

Le site est structuré en MVC (Modele / Vue / Controller), très pratique pour les applications web. Pour comprendre comment cela fonctionne. Vous pouvez-vous référer à ce lien [Wikipedia](https://fr.wikipedia.org/wiki/Mod%C3%A8le-vue-contr%C3%B4leur/).

## API, langages et librairies utilisés

Les différentes API que Mailcooking profitent sont : 

* [Stripe](https://stripe.com/fr)

Pour commencer la configuration et l'optimisation de l'application, il est préférable de comprendre les différents langages utilisés pour faire fonctionner Mailcooking :

* PHP 5.6
* Javascript (dont l'utilisation du framework jQuery)
* HTML / CSS (SCSS est préférable)

De multiples librairies sont égalements exploitées : 

* [Turbolinks](https://github.com/turbolinks/turbolinks)
* [jQuery UI](http://jqueryui.com/)
* [HTML2Canvas](https://html2canvas.hertzen.com/)
* [jQuery Minicolors](https://labs.abeautifulsite.net/jquery-minicolors/)
* [Croppie](https://github.com/foliotek/croppie)
* [Medium Editor](https://github.com/yabwe/medium-editor)
* [Undo manager](https://github.com/ArthurClemens/Javascript-Undo-Manager)

Pour ce qui est la base de données, l'application gère cela avec PHPMyAdmin, une application Web de gestion pour les systèmes de gestion de base de données MySQL réalisée en PHP.

### Installation

Tout d'abord et pour commencer, une plate-forme de développement Web est obligatoire (ou pas dans certains cas), je vous conseille d'y installer [Wamp](http://www.wampserver.com/) pour Windows ou [MAMP](https://www.mamp.info/de/) pour OS X.

Ensuite, il va vous falloir être muni de l'invite de commande, ou d'un émulateur (je peux vous conseiller [Cmder](http://cmder.net/)). Quelques lignes de commandes vont être nécessaires pour le bon fonctionnement de Mailcooking. 

[Composer](https://getcomposer.org/) est nécessaire pour faire appel aux differents paquets (comme [Stripe PHP](https://github.com/stripe/stripe-php)). Vous devez donc l'installer sur votre système.

Une fois que avez cloné le dossier sur votre serveur local, munissez-vous de votre terminal et placez-vous sur le dossier mailcooking. Téléchargez ensuite les paquets via Composer : 

```
Composer install
```

Pour ce qui est du préprocesseur SASS, l'installation de [COMPASS](http://compass-style.org/) est donc obligatoire, démarrez donc votre compilateur via la commande :
```
Compass watch
```

Et voilà, vous êtes prêt pour optimiser l'application, n'oubliez d'y inclure la base de données ;)

### Aides fournies

Evidemment que je ne vais pas vous laisser un code sans commentaire ! :p 

![](https://media.giphy.com/media/gw3MYmhxEv8T52ow/giphy.gif)

Chaque controllers est commenté de A à Z, mais un minimum de connaissances en PHP est requis (sinon ce serait trop simple). Pour ce qui est de la plus grosse partie du développement, je veux bien entendu parler du builder, les scripts sont découpés en fonction de leur utilité.

Vous pouvez me contacter par tel ou par mail (JC & Antoine ont mes coordonnées). #noSkype

## Versioning

La version finalisée par Victor de la Fouchardière se trouve ici : 

## Conclusion

C'est partit et ne casse pas tout ! 

![](http://ljdchost.com/L8am6Ta.gif)
