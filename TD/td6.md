# TD6 : Observers

Documentation Magento : https://developer.adobe.com/commerce/php/development/components/events-and-observers/

Nous allons écouter l'événement catalog_product_save_after et écrire un message dans les logs Magento.

Pour register à l'event, créer le fichier `etc/adminhtml/events.xml` avec le contenu suivant :

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Event/etc/events.xsd">
   <event name="catalog_product_save_after">
      <observer name="cms_log_product_save" instance="Univ\Cms\Observer\LogProductSave" />
   </event>
</config>
```

Pour exécuter du code au déclenchement de l'event, créez le fichier `Observer/LogProductSave.php` avec le contenu suivant :

```php
<?php
namespace Univ\Cms\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

class LogProductSave implements ObserverInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        // Récupération de l'objet produit passé dans l'événement
        $product = $observer->getEvent()->getProduct();
        $productName = $product->getName();

        // Écriture dans var/log/system.log
        $this->logger->info("L'observer a détecté la sauvegarde du produit : " . $productName);
    }
}
```

## Pour aller plus loin…

> Ajouter une vérification au moment du passage d'une commande : Si le montant est inferieur à 20e, une erreure empeche de passer commande
