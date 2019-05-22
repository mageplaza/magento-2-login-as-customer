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

namespace Mageplaza\LoginAsCustomer\Controller\Login;

use Exception;
use Magento\Checkout\Model\Cart;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Mageplaza\LoginAsCustomer\Helper\Data;
use Mageplaza\LoginAsCustomer\Model\LogFactory;

/**
 * Class Index
 * @package Mageplaza\LoginAsCustomer\Controller\Login
 */
class Index extends Action
{
    /**
     * @var AccountRedirect
     */
    protected $accountRedirect;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var LogFactory
     */
    protected $_logFactory;

    /**
     * @var Cart
     */
    protected $checkoutCart;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param Session $customerSession
     * @param AccountRedirect $accountRedirect
     * @param Cart $checkoutCart
     * @param Data $helper
     * @param LogFactory $logFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        AccountRedirect $accountRedirect,
        Cart $checkoutCart,
        Data $helper,
        LogFactory $logFactory
    ) {
        $this->session = $customerSession;
        $this->accountRedirect = $accountRedirect;
        $this->checkoutCart = $checkoutCart;
        $this->_logFactory = $logFactory;
        $this->helperData = $helper;

        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Forward|Redirect|ResultInterface
     */
    public function execute()
    {
        $token = $this->getRequest()->getParam('key');

        $log = $this->_logFactory->create()->load($token, 'token');
        if (!$log || !$log->getId() || $log->getIsLoggedIn() || !$this->helperData->isEnabled()) {
            return $this->_redirect('noRoute');
        }

        try {
            if ($this->session->isLoggedIn()) {
                $this->session->logout();
            } else {
                $this->checkoutCart->truncate()->save();
            }
        } catch (Exception $e) {
            $this->messageManager->addNoticeMessage(__('Cannot truncate cart items.'));
        }

        try {
            $this->session->loginById($log->getCustomerId());
            $this->session->regenerateId();

            $log->setIsLoggedIn(true)
                ->save();

            $redirectUrl = $this->accountRedirect->getRedirectCookie();
            if (!$this->helperData->getConfigValue('customer/startup/redirect_dashboard') && $redirectUrl) {
                $this->accountRedirect->clearRedirectCookie();
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setUrl($this->_redirect->success($redirectUrl));

                return $resultRedirect;
            }
        } catch (Exception $e) {
            $this->messageManager->addError(
                __('An unspecified error occurred. Please contact us for assistance.')
            );
        }

        return $this->accountRedirect->getRedirect();
    }
}
