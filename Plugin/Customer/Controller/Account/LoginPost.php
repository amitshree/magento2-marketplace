<?php

namespace Amitshree\Marketplace\Plugin\Customer\Controller\Account;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Api\CustomerRepositoryInterface;
use  Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Response\Http as ResponseHttp;


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

    /** @var Http **/
    protected $responseHttp;

    protected $currentCustomer;

    /** @var AccountManagementInterface */
    protected $customerAccountManagement;


    public function __construct(
        Session $customerSession,
        Validator $formKeyValidator,
        CustomerRepositoryInterface $customerRepositoryInterface,
        ManagerInterface $messageManager,
        ResponseHttp $responseHttp,
        AccountManagementInterface $customerAccountManagement
    )
    {
        $this->session = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->messageManager = $messageManager;
        $this->responseHttp = $responseHttp;
        $this->customerAccountManagement = $customerAccountManagement;
    }

    public function aroundExecute(\Magento\Customer\Controller\Account\LoginPost $loginPost, \Closure $proceed)
    {

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('before execute');

        if ($loginPost->getRequest()->isPost()) {
            $logger->info('111');
            $login = $loginPost->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
                $logger->info('222');
                try {
                    $customer = $this->getCustomer($login['username']);
                    if (!empty($customer->getCustomAttributes())) {
                        if ($this->isAVendorAndAccountNotApproved($customer)) {
                            $this->messageManager->addErrorMessage(__('Your account is not approved. Kindly contact website admin for assitance.'));
                            $this->responseHttp->setRedirect('customer/account/login');
                            //@todo:: redirect to last visited url
                        } else {
                            return $proceed();
                        }
                    } else {
                        // if no custom attributes found
                        return $proceed();
                    }
                }
                catch (\Exception $e)
                {
                    $message = "Invalid User credentials.";
                    $this->messageManager->addError($message);
                    $this->session->setUsername($login['username']);
                    $this->responseHttp->setRedirect('customer/account/login');
                }

            }
            else {
                // call the original execute function
                return $proceed();
            }
        }
        else {
            // call the original execute function
            return $proceed();
        }
    }

    /**
     * @param $email
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomer($email)
    {
        $this->currentCustomer = $this->customerRepositoryInterface->get($email);
        return $this->currentCustomer;
    }
    /**
     * Check if customer is a vendor and account is approved
     * @return bool
     */
    public function isAVendorAndAccountNotApproved($customer)
    {
        $isVendor = $customer->getCustomAttribute('is_vendor')->getValue();
        $isApprovedAccount = $customer->getCustomAttribute('approve_account')->getValue();
        if($isVendor && !$isApprovedAccount)
        {
            return true;
        }
        return false;
    }
}