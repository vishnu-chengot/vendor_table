<?php
namespace Codilar\VendorTable\Api;

use Magento\Catalog\Api\Data\ProductInterface;

interface CustomAttributeInterface
{
    /**
     * Get the custom attribute for a product by SKU
     *
     * @param string $sku
     * @return array
     */
    public function getCustomAttribute($sku);

    /**
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterGet(ProductInterface $product);
}
