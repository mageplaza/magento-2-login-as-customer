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

namespace Mageplaza\LoginAsCustomer\Plugin;

use Magento\Sales\Block\Adminhtml\Order\View;
use Mageplaza\LoginAsCustomer\Helper\Data;

/**
 * Class AddButton
 * @package Mageplaza\LoginAsCustomer\Plugin
 */
class AddButton
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * AddButton constructor.
     *
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param View $subject
     */
    public function beforeGetBackUrl(View $subject)
    {
        $customerId = $subject->getOrder()->getCustomerId();
        if ($customerId && $this->helper->isAllowLogin()) {
            $subject->addButton('login_as_customer', [
                'label'    => __('Login as Customer'),
                'class'    => 'login-as-customer',
                'on_click' => sprintf("window.open('%s');", $subject->getUrl('mploginascustomer/login/index', ['id' => $customerId]))
            ], 60);
        }
    }
}
