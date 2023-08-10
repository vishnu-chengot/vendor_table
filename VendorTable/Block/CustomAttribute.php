<?php
namespace Codilar\VendorTable\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;

class CustomAttribute extends \Magento\Framework\View\Element\Template
{
    protected $_productRepository;


    protected $_registry;

    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_productRepository = $productRepository;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function getProductAttribute($attributeCode)

    {
        
        /** @var Product $product */
        $product = $this->getCurrentProduct();



        if (!$product instanceof Product) {
            return '';
        }

        return $product->getData($attributeCode);
    }

     public function getCurrentProduct()
    {        
        return $this->_registry->registry('current_product');
    } 

}
