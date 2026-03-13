# TD4 : Ajout d'une page custom

## Création de la page

Définissez la route à l’aide du fichier `routes.xml` situé dans le dossier `Univ/Cms/etc/frontend`, en y insérant le code suivant :

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <router id="standard">
        <route id="plop" frontName="plop">
            <module name="Univ_Cms"/>
        </route>
    </router>
</config>
```

L’URL de notre nouvelle page sera : `<frontName>/<controler_folder_name>/<controller_class_name>`. Notre URL sera donc : `plop/index/index`.

Dans Magento 2, chaque action possède sa propre classe implémentant la méthode execute(). Créez le fichier `Index.php` dans le dossier ` Univ/Cms/Controller/Index` avec le code suivant :

```php
<?php
namespace Univ\Cms\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action {
    
    protected $_resultPageFactory;
    
    public function __construct(    
        Context $context,    
        PageFactory $resultPageFactory    
    ) {    
        $this->_resultPageFactory = $resultPageFactory;    
        parent::__construct($context);
    }
    
    public function execute() {
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;    
    }
}
```


## Ajout d'un bloc sur la page

Nous allons créer une classe de bloc simple avec la méthode getPlopText() qui renvoie la chaîne « Plop ».

Créez un fichier Plop.php dans le dossier Univ/Cms/Block avec le code suivant :

```php
<?php
namespace Univ\Cms\Block;
use Magento\Framework\View\Element\Template;

class Plop extends Template {
    public function getPlopText() {
        return 'Plop';
    }
}
```

Les fichiers de layout et templates sont placés dans le dossier `view` du module. Ce dossier peut contenir trois sous-dossiers : « adminhtml », « base » et « frontend ».

Utilisez le code ci-dessous pour créer un fichier plop_index_index.xml dans le dossier Univ/Cms/view/frontend/layout :

```xml
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd" layout="1column">
    <body>
        <referenceContainer name="content">
            <block class="Univ\Cms\Block\Plop" name="plop" template="plop.phtml"/>
        </referenceContainer>
    </body>
</page>
```

Chaque page possède un fichier layout. Pour notre action de contrôleur, ce gestionnaire est `plop_index_index`. Dans notre fichier de mise en page, nous avons ajouté un bloc au conteneur de contenu et défini son template sur `plop.phtml`

Créer dans le dossier `Univ/Cms/view/frontend/templates`

```html
<h1><?php echo $this->getPlopText(); ?></h1>
```

Ouvrez l'URL `/plop/index/index` dans votre navigateur pour vérifier le résultat.

## Pour aller plus loin…

> Placer le bloc `plop` sur les pages produits, apres le SKU du produit. Vous aurez besoin d'analyser le layout de la page produit pour le placer au bon endroit.

> Afficher le temps restants avant xxh pour recevoir le produit dès demain ("Passez commande avant 12h (x heures restantes) pour recevoir ce produit à partir du 14/03/26")