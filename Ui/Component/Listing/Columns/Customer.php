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

namespace Mageplaza\LoginAsCustomer\Ui\Component\Listing\Columns;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Customer
 * @package Mageplaza\LoginAsCustomer\Ui\Component\Listing\Columns
 */
class Customer extends Column
{
    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * Customer constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CustomerRepository $customerRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CustomerRepository $customerRepository,
        array $components = [],
        array $data = []
    ) {
        $this->customerRepository = $customerRepository;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     *
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $customerId = $item['customer_id'];

                $customer = $this->customerRepository->getById($customerId);
                if ($customer && $customer->getId()) {
                    $item['customer_id'] = $customer->getFirstname() . ' ' . $customer->getLastname() . ' <' . $customer->getEmail() . '>';
                } else {
                    $item['customer_id'] = $item['customer_name'] . ' <' . $item['customer_email'] . '>';
                }
            }
        }

        return $dataSource;
    }
}
