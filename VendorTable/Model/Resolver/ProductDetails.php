<?php

namespace Codilar\VendorTable\Model\Resolver;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class ProductDetails implements ResolverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * ProductDetails constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        
        
        $sku = $args['sku'];

        try {
            $product = $this->productRepository->get($sku);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__("Product with sku %1 not found", $sku));
        }

        return [
            'id' => $product->getId(),
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'custom_attribute' => $product->getCustomDatapatch(),
        ];
    }
}
