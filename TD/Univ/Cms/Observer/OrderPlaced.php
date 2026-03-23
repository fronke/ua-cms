<?php
namespace Univ\Cms\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

// dans etc/frontend/events.xml => sales_order_place_before
class OrderPlaced implements ObserverInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $this->logger->info("Montant de la commande : " . $order->getGrandTotal());
        if ($order->getGrandTotal() < 20) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Le montant minimum est de 20€.'));
        }
    }
}
