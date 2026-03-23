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

        if (version_compare($context->getVersion(), '1.0.3', '<')) {

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

        if (version_compare($context->getVersion(), '1.0.4', '<')) {

            $eavSetup = $this->eavSetupFactory->create();
            $eavSetup->addAttribute(
                Product::ENTITY,
                'likes_count',
                [
                    'group'         => 'Product Details',
                    'type'          => 'int',
                    'label'         => 'Nombre de likes',
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
