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
