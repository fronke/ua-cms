<?php

namespace Univ\Cms\Plugin;


use Psr\Log\LoggerInterface;

class CartPlugin
{
    protected $logger;
    protected $messageManager;

    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\Message\ManagerInterface $messageManager
    )
    {
        $this->logger = $logger;
        $this->messageManager = $messageManager;
    }

    public function beforeAddProduct(
        \Magento\Checkout\Model\Cart $subject,
                                     $productInfo,
                                     $requestInfo = null
    )
    {
        if (is_numeric($requestInfo)) {
            $requestInfo = ['qty' => 2];
        } else {
            $requestInfo['qty'] = 2;
        }

        return [$productInfo, $requestInfo];
    }

    public function afterAddProduct(
        \Magento\Checkout\Model\Cart $subject, $result
    )
    {
        $this->displayCongrats();
        return $result;
    }

    public function displayCongrats()
    {
        // On ajoute un message de succès qui s'affichera sur le front
        $this->messageManager->addSuccessMessage(
            __('Félicitations ! Votre produit a été ajouté avec succès au panier.')
        );
        $this->logger->info("Bravo pour l'ajout");
    }

    public function aroundAddProduct(
        \Magento\Checkout\Model\Cart $subject,
        callable                     $proceed,
                                     $productInfo,
                                     $requestInfo = null
    )
    {
        if (!$this->isCartValid($productInfo)) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Ajout interdit.'));
        }

        $returnValue = $proceed($productInfo, $requestInfo);

        return $returnValue;
    }

    public function isCartValid($productInfo)
    {

        return true;
    }
}
