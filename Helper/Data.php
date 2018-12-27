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

namespace Mageplaza\LoginAsCustomer\Helper;

use Magento\Customer\Model\Customer;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\Core\Helper\AbstractData;

/**
 * Class Data
 * @package Mageplaza\LoginAsCustomer\Helper
 */
class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'mploginascustomer';

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $_authorization;

    /**
     * @var \Magento\Framework\Math\Random
     */
    protected $mathRandom;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\AuthorizationInterface $authorization
     * @param \Magento\Framework\Math\Random $random
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        \Magento\Framework\AuthorizationInterface $authorization,
        \Magento\Framework\Math\Random $random
    )
    {
        $this->_authorization = $authorization;
        $this->mathRandom = $random;

        parent::__construct($context, $objectManager, $storeManager);
    }

    /**
     * @return bool
     */
    public function isAllowLogin()
    {
        return $this->_authorization->isAllowed('Mageplaza_LoginAsCustomer::allow');
    }

    /**
     * @return string
     */
    public function getLoginToken()
    {
        return $this->mathRandom->getUniqueHash();
    }

    /**
     * @param Customer $customer
     *
     * @return \Magento\Store\Api\Data\StoreInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStore($customer)
    {
        if ($storeId = $customer->getStoreId()) {
            return $this->storeManager->getStore($storeId);
        }

        return $this->storeManager->getDefaultStoreView();
    }
}