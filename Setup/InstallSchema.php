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

namespace Mageplaza\LoginAsCustomer\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'mp_login_as_customer'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('mp_login_as_customer'))
            ->addColumn('log_id', Table::TYPE_INTEGER, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary'  => true
            ], 'Entity ID')
            ->addColumn('admin_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false, 'default' => '0'], 'Admin ID')
            ->addColumn('admin_email', Table::TYPE_TEXT, 255, [], 'Admin Email')
            ->addColumn('admin_name', Table::TYPE_TEXT, 255, [], 'Admin Name')
            ->addColumn('customer_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false, 'default' => '0'], 'Customer ID')
            ->addColumn('customer_email', Table::TYPE_TEXT, 255, [], 'Customer Email')
            ->addColumn('customer_name', Table::TYPE_TEXT, 255, [], 'Customer Name')
            ->addColumn('token', Table::TYPE_TEXT, 64, [], 'Token')
            ->addColumn('is_logged_in', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '0'], 'Is Logged In')
            ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Creation Time')
            ->setComment('Login As Customer Logs table');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
