# TD4 : Ajout de nouveaux attributs produits

Nous allons créer un nouvel attribut produit grâce au module et au script d'installation et d'update

Créez le fichier `Univ/Cms/Setup/UpgradeData.php` avec le contenu suivant :

```php
<?php
declare(strict_types=1);

namespace Univ\Cms\Setup;

use Univ\Cms\Model\Attribute\Source\BatteryType as Source;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $eavSetupFactory;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @suppressWarnings(PHPMD.ExessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {

            $eavSetup = $this->eavSetupFactory->create();
            $eavSetup->addAttribute(
                Product::ENTITY,
                'battery_type',
                [
                    'group'         => 'Product Details',
                    'type'          => 'varchar',
                    'label'         => 'Type de piles',
                    'input'         => 'select',
                    'source'        => Source::class,
                    'required'      => false,
                    'sort_order'    => 50,
                    'global'        => ScopedAttributeInterface::SCOPE_GLOBAL,
                    'is_used_in_grid'               => false,
                    'is_visible_in_grid'            => false,
                    'is_filterable_in_grid'         => false,
                    'visible'                       => true,
                    'is_html_allowed_on_frontend'   => true,
                    'visible_on_front'              => true,
                ]
            );
        }
    }
}
```


Créez le fichier `Univ/Cms/Model/Attribute/Source/BatteryType.php` suivant :

```php
<?php
declare(strict_types=1);

namespace Univ\Cms\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class BatteryType extends AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions(): array
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('AAA'), 'value' => 'aaa'],
                ['label' => __('AA'), 'value' => 'aa'],
                ['label' => __('9V'), 'value' => '9v'],
                ['label' => __('Pile bouton LR44'), 'value' => 'lr44'],
            ];
        }
        return $this->_options;
    }
}
```

Changer la version du module en modifiant le fichier `etc/module.xml`
```
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="Univ_Cms" setup_version="1.0.1"/>
</config>
```

Mettre le module à jour

## Pour aller plus loin…

> Créer un nouvel attribut produit pour renseigner la date de retour en stock. Afficher le nombre de jours avant le retour en stock sur la fiche produit.