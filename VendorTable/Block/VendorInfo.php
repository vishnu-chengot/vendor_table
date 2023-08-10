<?php

namespace Codilar\VendorTable\Block;


use Magento\Checkout\Model\Cart;
use Magento\Catalog\Api\ProductRepositoryInterface;

/**
 * AdditionalProInfo
 */
class VendorInfo extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $_cart;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Cart $cart,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->_cart = $cart;
        $this->_productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    /**
     * @return additional information data
     */ 
    public function getAdditionalData()
    {
        $cartItems = $this->_cart->getQuote()->getAllVisibleItems();
        $additionalData = [];
        foreach ($cartItems as $item) {
            $productId = $item->getProduct()->getId();
            $product = $this->_productRepository->getById($productId);
            $customAttributeValue = $product->getCustomAttribute('Vendor_Name')? $product->getCustomAttribute('Vendor_Name')->getValue() : null;
            $attrLabel = $product->getResource()->getAttribute('Vendor_Name')->getStoreLabel();
            $additionalData[] = [
                 'attrLabel' => $attrLabel,
                'custom_attribute_value' => $customAttributeValue
            ];
        }
        return $additionalData;
    }
}
