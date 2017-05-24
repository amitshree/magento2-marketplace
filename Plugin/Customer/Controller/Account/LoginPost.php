<?php

namespace Amitshree\Marketplace\Plugin\Customer\Controller\Account;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Api\CustomerRepositoryInterface;
use  Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Response\Http as ResponseHttp;


class LoginPost
{
    const ZERO = 0;
    const One =1;
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

    /** @var Http **/
    protected $responseHttp;

    public function __construct(
        Session $customerSession,
        Validator $formKeyValidator,
        CustomerRepositoryInterface $customerRepositoryInterface,
        ManagerInterface $messageManager,
        ResponseHttp $responseHttp
    )
    {
        $this->session = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->messageManager = $messageManager;
        $this->responseHttp = $responseHttp;
    }

    public function aroundExecute(\Magento\Customer\Controller\Account\LoginPost $loginPost, \Closure $proceed)
    {

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('before executeee');

        if ($loginPost->getRequest()->isPost()) {
            $logger->info('111');
            $login = $loginPost->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
                $logger->info('222');
                $customer = $this->customerRepositoryInterface->get($login['username']);
              
                if(!empty($customer->getCustomAttributes())){
                    $is_vendor = $customer->getCustomAttribute('is_vendor')->getValue();
                    $approve_account = $customer->getCustomAttribute('approve_account')->getValue();
                     $logger->info('vendor'.$is_vendor.' approve_account'.$approve_account);
                    if($is_vendor == self::One && $approve_account == self::ZERO)
                    {
                        $logger->info('is a vendor');
                        $this->messageManager->addErrorMessage(__('Your account is not approved. Kindly contact website admin for assitance.'));

                        $this->responseHttp->setRedirect('customer/account/login');

                        //@todo:: redirect to last visited url
                    }
                    else {
                        // call the original execute function
                        $logger->info('333');
                         return $proceed();
                    }
                }
                else {
                    $logger->info('444');
                    $logger->info('no custom attribute found');
                    // if no custom attributes found
                }
                
            }
            else {
                // call the original execute function
                $logger->info('555');
                return $proceed();
                }
        }
        else {
            // call the original execute function
            $logger->info('666');
            return $proceed();
        }
    }
}