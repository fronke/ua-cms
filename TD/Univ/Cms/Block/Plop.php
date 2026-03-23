<?php
namespace Univ\Cms\Block;
use Magento\Framework\View\Element\Template;

class Plop extends Template {
    public function getPlopText() {
        return 'Plop';
    }

    public getRemainTime() {
        return "2h restantes"
    }
}
