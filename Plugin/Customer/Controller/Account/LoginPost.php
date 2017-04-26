<?php

namespace Amitshree\Marketplace\Plugin\Customer\Controller\Account;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Api\CustomerRepositoryInterface;
use  Magento\Framework\Message\ManagerInterface;


class LoginPost
{

    /**
     * @var Session
     */
    protected $session;

    /** @var Validator */
    protected $formKeyValidator;

    /** @var CustomerRepositoryInterface */
    protected $customerRepositoryInterface;
    
    /** @var ManagerInterface **/
    protected $messageManager;

    public function __construct(
        Session $customerSession,
        Validator $formKeyValidator,
        CustomerRepositoryInterface $customerRepositoryInterface,
        ManagerInterface $messageManager
    )
    {
        $this->session = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->messageManager = $messageManager;
    }

    public function beforeExecute(\Magento\Customer\Controller\Account\LoginPost $loginPost)
    {

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('before execute');

        if ($loginPost->getRequest()->isPost()) {
            $login = $loginPost->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {

                $customer = $this->customerRepositoryInterface->get($login['username']);
              
                if(!empty($customer->getCustomAttributes())){
                    $is_vendor = $customer->getCustomAttribute('is_vendor')->getValue();
                    $approve_account = $customer->getCustomAttribute('approve_account')->getValue();
                     $logger->info('vendor'.$is_vendor.' approve_account'.$approve_account);
                    if($is_vendor == 1 && $approve_account == 0)
                    {
                        $logger->info('inside');
                        $this->messageManager->addErrorMessage('Your account is not approved. Kindly contact website admin for assitance.');
                        die;
                    }
                }
                
            }
        }
    }
}