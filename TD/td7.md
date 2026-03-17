# TD7 : Plugins

Documentation Magento :  https://developer.adobe.com/commerce/php/development/components/plugins/

Nous allons agir sur la classe Magento\Checkout\Model\Cart. L'objectif est de modifier le comportement de l'ajout d'un produit au panier.

Créer le fichier `etc/frontend/di.xml` pour déclarer le plugin avec le contenu suivant :

```xml
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="Magento\Checkout\Model\Cart">
        <plugin name="univ_cms_cart_plugin"
                type="Univ\Cms\Plugin\CartPlugin"
                sortOrder="10"/>
    </type>
</config>
```


Créez le fichier `Plugin/CartPlugin.php` avec le code suivant pour intercepter la méthode addProduct($productInfo, $requestInfo = null).

```php
<?php
namespace Univ\Cms\Plugin;

class CartPlugin
{
    public function beforeAddProduct(
        \Magento\Checkout\Model\Cart $subject,
        $productInfo,
        $requestInfo = null
    ) {
        if (is_numeric($requestInfo)) {
            $requestInfo = ['qty' => 3];
        } else {
            $requestInfo['qty'] = 3;
        }
    
        return [$productInfo, $requestInfo]; // On doit retourner les arguments sous forme de tableau
    }
}
```

Ajouter la méthode suivante au fichier `Plugin/CartPlugin.php`

```php
public function afterAddProduct(
    \Magento\Checkout\Model\Cart $subject,
    $result // Le résultat de la méthode originale
) {
    $this->displayCongrats();
    return $result;
}

public function displayCongrats() {
    print("Bravo pour votre achat");
}
```

Ajouter la méthode suivante au fichier `Plugin/CartPlugin.php`

```php
public function aroundAddProduct(
    \Magento\Checkout\Model\Cart $subject,
    callable $proceed, // La fonction qui représente la méthode originale
    $productInfo,
    $requestInfo = null
) {
    // Logique AVANT
    if (!$this->isCartValid()) {
        throw new \Magento\Framework\Exception\LocalizedException(__('Ajout interdit.'));
    }
    
    // Exécution de la méthode originale
    $returnValue = $proceed($productInfo, $requestInfo);

    // Logique APRÈS
    return $returnValue;
}

public function isCartValid() {
    return true;
}
```


## Pour aller plus loin…

> Implémenter la fonction isCartValid() en vérifiant que le panier ne contient pas un produit interdit
 
> Implémenter la fonction displayCongrats() pour féliciter de l'achat du produit avec un message personnalisé selon la quantité (avec un Magento\Framework\Message\ManagerInterface)

> Quand on ajoute un produit, on double la quantité (plutôt que la forcer à 3)

