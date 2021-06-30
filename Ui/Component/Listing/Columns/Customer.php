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

use Exception;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Mageplaza\LoginAsCustomer\Model\LogFactory;

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
     * @var LogFactory
     */
    protected $_logFactory;

    /**
     * Customer constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CustomerRepository $customerRepository
     * @param LogFactory $logFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CustomerRepository $customerRepository,
        LogFactory $logFactory,
        array $components = [],
        array $data = []
    ) {
        $this->customerRepository = $customerRepository;
        $this->_logFactory        = $logFactory;

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

                try {
                    $customer = $this->customerRepository->getById($customerId);
                    if ($customer && $customer->getId()) {
                        $item['customer_id'] = $customer->getFirstname() . ' ' . $customer->getLastname() . ' <' . $customer->getEmail() . '>';
                    } else {
                        $item['customer_id'] = $item['customer_name'] . ' <' . $item['customer_email'] . '>';
                    }
                } catch (Exception $e) {
                    $log = $this->_logFactory->create()->load($item['customer_id'], 'customer_id');
                    $log->delete();
                }
            }
        }

        return $dataSource;
    }
}
