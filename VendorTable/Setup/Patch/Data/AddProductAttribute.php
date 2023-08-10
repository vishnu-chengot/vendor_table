<?php
namespace Codilar\VendorTable\Setup\Patch\Data;
 
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
 
class AddProductAttribute implements DataPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /** @var EavSetupFactory */
    private $eavSetupFactory;
 
    /**
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
 
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'Vendor_Name',
            [
                'type' => 'text',
                'frontend' => '',
                'label' => 'Vendor Name',
                'input' => 'text',
                'class' => '',
                'source' => '',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'is_used_in_grid' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'is_wysiwyg_enabled'      => false,
                'unique' => false,
                'apply_to' => ''
            ]
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }
 
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
 
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
