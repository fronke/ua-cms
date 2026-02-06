# TD 3 : Création d'un module

Créer le dossier `Univ/Cms` du module dans `app/code`

Créer le fichier `registration.php` à la racine du module

```php
<?php
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Univ_Cms',
    __DIR__);
```

Créer le fichier `module.xml` dans le dossier `etc/` du module
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="Univ_Cms"/>
</config>
```

Installer le module avec la commande CLI `setup:upgrade` puis avec la commande `setup:di:compile`

Vérifier que le module est installé de 4 façons differentes :
* Commande CLI
* Fichier de configuration
* Base de donnée
* Backend Admin > Stores > Configuration > Advanced > Advanced

## Pour aller plus loin…

> Créer un deuxième module qui dépend du premier (grâce à la balise sequence) et l’installer, puis le désactiver avec la commande `module:disable`
