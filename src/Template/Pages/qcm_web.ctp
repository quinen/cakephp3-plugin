<?php

$questions = [
    [
        'type'      => "PHP",
        'niveau'    => 1,
        '?'         => "avec quel fonction peut on convertir une chaine \"banane,pomme,poire\" en tableau ['banane','pomme','poire']",
        '!'         => "on peut utiliser la fonction explode(',',\$chaine), la fonction pour faire l'inverse est implode()"
    ],
    [
        'type'      => "PHP",
        'niveau'    => 2,
        '?'         => "qu'est ce que le PSR ? pouvez vous citez des exemples",
        '!'         => "c'est le PHP Standard recommandation, c'est un consortium de developpeurs travaillant sur des".
        " projets PHP reconnus qui se mettent d'accord sur des normes de developpemet en PHP, on peut y retrouver des ".
        "regles d'ecritures du code (espaces, indentation), des methodes pour logger, autoloading, mettre en cache, http media link ... etc..."
    ],
    [
        'type'      => "Theorie",
        'niveau'    => 1,
        '?'         => "connaissez vous DRY ? un exemple d'application ?",
        '!'         => "Dont Repeat Yourself : on ne se repete pas, par exemple, si on a deja fait un bout de code qui met en majuscules ".
        "les elements d'un tableau, et que l'on doit refaire ce traitement alors on creer une fonction/methode unique pour centraliser ce traitement"
    ],
    [
        'type'      => "Theorie",
        'niveau'    => 2,
        '?'         => "connaissez vous SOLID ? pouvez vous en citer un principe ?",
        '!'         => [
            "Single responsability : une classe, une fonction ou une méthode doit avoir une et une seule responsabilité",
            "Open/closed : « Ouverte » signifie qu'elle a la capacité d'être étendue. « Fermée » signifie qu'elle ne peut être modifiée que par extension, notion d'abstraction et polymorphisme",
            "Liskov substitution : exemple a l'encontre du principe, une classe Carre etendant une classe Rectangle, si je change la hauteur ou la largeur du carré alors les 2 valeurs ne sont plus egale (qui est une des regles ajoutée au Carre)",
            "Interface segregation : un client ne doit pas etre forcé de dependre d'une methode qu'il n'utilise pas",
            "Dependency inversion : il faut dependre des abstraction, pas des implementations"
        ]
    ],
    [
        'type'      => "Culture generale",
        'niveau'    => 2,
        '?'         => "connaissez vous PWA (on peut demander Progressive Web App)? quel en sont les avantages ?",
        '!'         => [
            "Responsive : s'adapte a toutes les formes d'ecrans : ordinateur, tablette, mobile",
            "Independant a la connection : permet d'utiliser l'application meme en cas de deconnection/bas debit",
            "Aspect natif : prend l'aspect de la plateforme rencontrée au niveau interface : iOS, Android, Windows, macOS",
            "Mis a jour : les informations sont toujours a jour",
            "Securisé: passe par la protocole HTTPS pour que l'ensemble des echanges soient cryptes",
            "Decouvrables : facilitation de fournitures des informations de l'application via un manifest pour les navigateurs, moteurs de recherches",
            "Engagement : gestion de notifications",
            "Installable en local",
            "Facile a echanger via un simple lien web"
        ]
    ],
    [
        'type'      => "PHP",
        'niveau'    => 1,
        '?'         => "quel methode magique est appelé lors de l'instanciation d'un classe ?",
        '!'         => "__construct",
    ],
    [
        'type'      => "PHP",
        'niveau'    => 2,
        '?'         => "connaissez vous les methodes magiques ? pouvez vous me citer un cas d'application",
        '!'         => [
            "__construct & __destruct : appelées lors de l'instanciation/destruction de la classe",
            "__call & __callStatic : permet de creer des methodes parametrables, appelé uniquement si la methode n'existe pas, ex: findBy{{nom_du_champ en entrée a filtré}}",
            "__get & __set : permet de parametrer des methodes d'acces aux proprietes",
            "__isset & unset : sont appelés respectivement lors des appels aux structure de language qui ont le meme nom",
            "__sleep & __wakeup : serialisation",
            "__toString : meme principe que java, retour de la classe si traitée comme une string",
            "__invoke : si la classe est traitée comme une fonction",
            "__set_state : retour de la methode var_export",
            "__debugInfo : retour de la fonction var_dump",
        ]
    ],
    [
        'type'      => "Culture generale",
        'niveau'    => 1,
        '?'         => "quels sont les ressources en ligne que vous utilisez",
        '!'         => [
            "MDN : Mozilla developper network, utile pour tout ce qui est HTML, CSS, JavaScript",
            "PHP.net : ressource officiel",
            "Stack Overflow : site de question/reponses entre developpeurs , point ++ si vous avez un compte",
            "W3School : -- site plus tres a jour sur les methodes modernes",
            "Reddit : forums specialisés sur chaque domaines, un multi-reddit avec differents language/specialtés est un +"
        ]
    ],
    [
        'type'      => "Frontend",
        'niveau'    => 1,
        '?'         => "vous avez 10 CSS et 10 JavaScript dans votre page, quels sont les pistes pour l'optimisation ?",
        '!'         => [
            "Reduction du nombre de fichier en faisant un simple cat (commande linux de concatenation des fichiers)",
            "s'assurer d'avoir une version minifié de chaque",
            "s'assurer de bien charger tous les fichiers css en premier et les fichier JavaScript en dernier",
        ]
    ],
    [
        'type'      => "Culture generale",
        'niveau'    => 1,
        '?'         => "Avez vous un compte en ligne ou vous stockez des snippets de codes ? voire des projets ?",
        '!'         => [
            "compte Github, Gitlab est un plus, participation des projets open sopurces ?",
            "snippets de code sur jsfiddle ou codepen",
            "s'assurer de bien placer tous les fichiers CSS en premier et les fichier JavaScript en dernier",
        ]
    ],
    [
        'type'      => "Frontend",
        'niveau'    => 1,
        '?'         => "quel est la difference entre un span et un div ?",
        '!'         => [
            "un span est une balise HTML inline, elle permet d'appliquer un style au milieu d'une phrase",
            "un div est une balise HTML block, elle permet de placer des elements dans la page avec un saut a la ligne juste apres",
            "/!\\ un div peut avoir le comportement d'un span avec du CSS"
        ]
    ],
];

$dls = collection($questions)->combine('?','!')->toArray();
echo $this->Html->dl($dls);
pr($dls);