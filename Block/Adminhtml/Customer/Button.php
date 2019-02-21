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

namespace Mageplaza\LoginAsCustomer\Block\Adminhtml\Customer;

use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Mageplaza\LoginAsCustomer\Helper\Data;

/**
 * Class Button
 * @package Mageplaza\LoginAsCustomer\Block\Adminhtml\Customer
 */
class Button extends GenericButton implements ButtonProviderInterface
{
    /**
     * @var Data
     */
    protected $_helper;

    /**
     * Button constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Data $helper
    ) {
        $this->_helper = $helper;

        parent::__construct($context, $registry);
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $customerId = $this->getCustomerId();
        $data = [];
        if ($customerId && $this->_helper->isAllowLogin()) {
            $data = [
                'label'      => __('Login as Customer'),
                'class'      => 'login-as-customer',
                'on_click'   => sprintf("window.open('%s');", $this->getLoginUrl()),
                'sort_order' => 60,
            ];
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->getUrl('mploginascustomer/login/index', ['id' => $this->getCustomerId()]);
    }
}
