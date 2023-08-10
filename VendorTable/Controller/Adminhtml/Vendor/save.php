<?php

namespace Codilar\VendorTable\Controller\Adminhtml\Vendor;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Controller\ResultFactory;
use Codilar\VendorTable\Api\VendorRepositoryInterface;
use Codilar\VendorTable\Api\Data\VendorInterface;

class save extends Action
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Codilar_VendorTable::entity';

    /**
     * @var VendorRepositoryInterface
     */
    protected $vendorRepository;
    
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * @param Context $context
     * @param VendorRepositoryInterface $vendorRepository
     * @param PageFactory $resultPageFactory
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(
        Context $context,
        VendorRepositoryInterface $vendorRepository,
        PageFactory $resultPageFactory,
        SessionManagerInterface $sessionManager
    )
    {
        parent::__construct($context);
        $this->vendorRepository = $vendorRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->sessionManager = $sessionManager;
    }
    
    /**
     * Save action
     */
    public function execute()
    {   
        $resultRedirect = $this->resultRedirectFactory->create();
        $vendor = $this->vendorRepository->getNew();
        
        $data = $this->getRequest()->getPost(); 
        
        try {
            if (!empty($data['id'])) {
                $vendor = $this->vendorRepository->getById($data['id']);
            }
            
            $vendor->setName($data['name']);
            $vendor->setDescription($data['description']);
           
            $this->vendorRepository->save($vendor);
            
            //check for `back` parameter
            if ($this->getRequest()->getParam('back')) { 
                return $resultRedirect->setPath('*/*/edit', ['id' => $vendor->getId(), '_current' => true, '_use_rewrite' => true]);
            }

            $this->messageManager->addSuccess(__('The Entity has been saved.'));

        } catch(\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        
        return $resultRedirect->setPath('*/*/');
    }
}
