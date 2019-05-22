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
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Math\Random;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Api\Data\StoreInterface;
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
     * @var AuthorizationInterface
     */
    protected $_authorization;

    /**
     * @var Random
     */
    protected $mathRandom;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param AuthorizationInterface $authorization
     * @param Random $random
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        AuthorizationInterface $authorization,
        Random $random
    ) {
        $this->_authorization = $authorization;
        $this->mathRandom = $random;

        parent::__construct($context, $objectManager, $storeManager);
    }

    /**
     * @return bool
     */
    public function isAllowLogin()
    {
        return $this->isEnabled() && $this->_authorization->isAllowed('Mageplaza_LoginAsCustomer::allow');
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getLoginToken()
    {
        return $this->mathRandom->getUniqueHash();
    }

    /**
     * @param Customer $customer
     *
     * @return StoreInterface|null
     * @throws NoSuchEntityException
     */
    public function getStore($customer)
    {
        if ($storeId = $customer->getStoreId()) {
            return $this->storeManager->getStore($storeId);
        }

        return $this->storeManager->getDefaultStoreView();
    }
}
