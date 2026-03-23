<?php

namespace Univ\Cms\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Ajax extends Action
{
    protected $resultJsonFactory;
    protected $productRepository;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productRepository = $productRepository;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $productId = $this->getRequest()->getParam('product_id');

        if (!$productId) {
            return $result->setData([
                'success' => false,
                'message' => 'ID du produit manquant'
            ]);
        }

        try {
            $product = $this->productRepository->getById($productId);

            $likesCount = (int) $product->getData('likes_count');
            $likesCount++;

            $product->setData('likes_count', $likesCount);
            $this->productRepository->save($product);

            return $result->setData([
                'success' => true,
                'likes_count' => $likesCount
            ]);
        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
