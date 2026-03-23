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
