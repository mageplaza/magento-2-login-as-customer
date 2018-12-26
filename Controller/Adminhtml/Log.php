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

namespace Mageplaza\LoginAsCustomer\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Customer\Model\CustomerFactory;
use Mageplaza\LoginAsCustomer\Helper\Data;
use Mageplaza\LoginAsCustomer\Model\LogFactory;

/**
 * Class Log
 * @package Mageplaza\LoginAsCustomer\Controller\Adminhtml
 */
abstract class Log extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mageplaza_LoginAsCustomer::logs';

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
    protected $_helper;

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
    )
    {
        $this->_customerFactory = $customerFactory;
        $this->_logFactory = $logFactory;
        $this->_helper = $helper;

        parent::__construct($context);
    }
}
