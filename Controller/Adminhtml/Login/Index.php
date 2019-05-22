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

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Url;
use Mageplaza\LoginAsCustomer\Helper\Data;
use Mageplaza\LoginAsCustomer\Model\LogFactory;

/**
 * Class Index
 * @package Mageplaza\LoginAsCustomer\Controller\Adminhtml\Login
 */
class Index extends Action
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
     * @param Context $context
     * @param CustomerFactory $customerFactory
     * @param LogFactory $logFactory
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        CustomerFactory $customerFactory,
        LogFactory $logFactory,
        Data $helper
    ) {
        $this->_customerFactory = $customerFactory;
        $this->_logFactory = $logFactory;
        $this->_loginHelper = $helper;

        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function execute()
    {
        if (!$this->_loginHelper->isEnabled()) {
            $this->messageManager->addErrorMessage(__('Module is not enabled.'));

            return $this->_redirect('customer');
        }

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
            'token'          => $token,
            'admin_id'       => $user->getId(),
            'admin_email'    => $user->getEmail(),
            'admin_name'     => $user->getName(),
            'customer_id'    => $customer->getId(),
            'customer_email' => $customer->getEmail(),
            'customer_name'  => $customer->getName()
        ])->save();

        $store = $this->_loginHelper->getStore($customer);
        $loginUrl = $this->_objectManager->create(Url::class)
            ->setScope($store)
            ->getUrl('mploginascustomer/login/index', ['key' => $token, '_nosid' => true]);

        return $this->getResponse()->setRedirect($loginUrl);
    }
}
