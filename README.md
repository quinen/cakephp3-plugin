# Quinen plugin for CakePHP 3

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require quinen/cakephp3 (not yet implemented)

dependency :

https://github.com/FriendsOfCake/bootstrap-ui

composer require friendsofcake/bootstrap-ui
./bin/cake plugin load BootstrapUI


```
# Intaller un enviro CakePHP 3 avec le plugin Quinen sur un ubuntu/windows bash
## Configuration Visual Studio Code : bash windows
> "terminal.integrated.shell.windows": "C:\\Windows\\sysnative\\bash.exe",
## Installer cakephp 
	### Installer composer
	> sudo apt install composer
	### installer unzip
	> sudo apt install unzip
	### intaller php-intl
	> sudo apt-get install php7.0-intl
	### intaller php-mbstring
	> sudo apt-get install php7.0-mbstring
	### intaller php-simplexml
	> sudo apt-get install php7.0-simplexml
> composer create-project --prefer-dist cakephp/app quinen.net
> cd quinen.net
> bin/cake server
	### on verifie que ca fonctionne
	http://localhost:8765/
## Installer le plugin Quinen
	### on creer le plugin Quinen
	> bin/cake bake plugin Quinen
	### on supprimme le contenu du dossier
	> cd plugins/Quinen
	> rm -rvf *
	### Generer une cle rsa (si besoin)
	> ssh-keygen
	> cat ~/.ssh/id_rsa.pub
	### aller sur github.com et ajouter le cle
	### descendre le projet (dans le cas present : git@github.com:quinen/cakephp3-plugin.git)
    > git clone git@github.com:quinen/cakephp3-plugin.git .
	### on installe la dependance FriendsOfCake/bootstrap-ui
	> composer require friendsofcake/bootstrap-ui
	> bin/cake plugin load BootstrapUI
## configurer cakephp avec les derniers liens
	### aller dans le fichier config/routes.php
	> $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home','plugin'=>"Quinen"]);
	### aller dans le fichier src/View/AppView.php et ajouter dans la methode initialize
	> $this->loadHelper('Html',['className'=>"Quinen.Html"]);