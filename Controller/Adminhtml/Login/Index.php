<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_LoginAsCustomer
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\LoginAsCustomer\Controller\Adminhtml\Login;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Url;
use Mageplaza\LoginAsCustomer\Helper\Data;
use Mageplaza\LoginAsCustomer\Model\LogFactory;

/**
 * Class Index
 * @package Mageplaza\LoginAsCustomer\Controller\Adminhtml\Login
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mageplaza_LoginAsCustomer::allow';

    /**
     * @var LogFactory
     */
    protected $_logFactory;

    /**
     * @var CustomerFactory
     */
    protected $_customerFactory;

    /**
     * @var Data
     */
    protected $_loginHelper;

    /**
     * Index constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param CustomerFactory $customerFactory
     * @param LogFactory $logFactory
     * @param Data $helper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        CustomerFactory $customerFactory,
        LogFactory $logFactory,
        Data $helper
    )
    {
        $this->_customerFactory = $customerFactory;
        $this->_logFactory = $logFactory;
        $this->_loginHelper = $helper;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $customerId = $this->getRequest()->getParam('id');
        $customer = $this->_customerFactory->create()->load($customerId);
        if (!$customer || !$customer->getId()) {
            $this->messageManager->addErrorMessage(__('Customer does not exist.'));

            return $this->_redirect('customer');
        }

        $user = $this->_auth->getUser();
        $token = $this->_loginHelper->getLoginToken();

        $log = $this->_logFactory->create();
        $log->setData([
            'token' => $token,
            'admin_id' => $user->getId(),
            'admin_email' => $user->getEmail(),
            'admin_name' => $user->getName(),
            'customer_id' => $customer->getId(),
            'customer_email' => $customer->getEmail(),
            'customer_name' => $customer->getName()
        ])->save();

        $store = $this->_loginHelper->getStore($customer);
        $loginUrl = $this->_objectManager->create(Url::class)
            ->setScope($store)
            ->getUrl('mploginascustomer/login/index', ['key' => $token, '_nosid' => true]);

        $this->getResponse()->setRedirect($loginUrl);
    }
}
