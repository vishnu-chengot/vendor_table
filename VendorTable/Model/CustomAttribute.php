<?php
namespace Codilar\VendorTable\Model;

use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Magento\Catalog\Api\Data\ProductExtensionInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Codilar\VendorTable\Api\CustomAttributeInterface;

class CustomAttribute implements CustomAttributeInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ProductExtensionFactory
     */
    private $productExtensionFactory;

    /**
     * CustomAttribute constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param ProductExtensionFactory $productExtensionFactory
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductExtensionFactory $productExtensionFactory
    ) {
        $this->productRepository = $productRepository;
        $this->productExtensionFactory = $productExtensionFactory;
    }

    /**
     * Get the name, price, and custom attribute for a product by SKU
     *
     * @param string $sku
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomAttribute($sku)
    {
        $product = $this->productRepository->get($sku);
        $name = $product->getName();
        $price = $product->getPrice();
        $customAttribute = $product->getData('Vendor_Name');
        return ['name' => $name, 'price' => 'Price:$'.$price, 'custom_attribute' => $customAttribute];
    }

    /**
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterGet(ProductInterface $product)
    {
        $productExtension = $product->getExtensionAttributes();
        if ($productExtension === null) {
            $productExtension = $this->productExtensionFactory->create();
        }
        $productExtension->setCustomAttribute($product->getData('Vendor_Name'));
        $product->setExtensionAttributes($productExtension);

        return $product;
    }
}
