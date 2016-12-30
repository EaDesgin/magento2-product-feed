<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Setup;


use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    const MAIN_TABLE = 'eadesign_pfeed';
    const STORE_TABLE = 'eadesign_pfeed_store';

    /**
     * Installs DB schema for the module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if ($installer->tableExists(self::MAIN_TABLE)) {
            $installer->endSetup();
            return;
        }

        $table = $installer->getConnection()
            ->newTable($installer->getTable(self::MAIN_TABLE))
            /** main rows */

            ->addColumn(
                'entity_id',
                Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Feed Id'
            )
            ->addColumn(
                'is_active',
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => '1'], '
                Product feed active?'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                100,
                ['nullable' => false],
                'Product feed name'
            )
            ->addColumn(
                'filename',
                Table::TYPE_TEXT,
                100,
                ['nullable' => false],
                'Product file name'
            )
            ->addColumn(
                'url',
                Table::TYPE_TEXT,
                500,
                ['nullable' => false],
                'Product feed URL'
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                500,
                ['nullable' => false],
                'Product feed description'
            )
            /** settings rows */

            ->addColumn(
                'delimiter',
                Table::TYPE_TEXT,
                500,
                [],
                'CSV delimiter'
            )
            ->addColumn(
                'stock_status',
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => '0'],
                'Stock status value for product'
            )
            ->addColumn(
                'status',
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => '0'],
                'Disabled/Enabled status value for product'
            )
            ->addColumn(
                'visibility',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0'],
                'Visibility value for product'
            )
            /** The product categories */

            ->addColumn(
                'categories',
                Table::TYPE_TEXT,
                '2M',
                [],
                'Product categories comma separated'
            )
            /** The product fields */

            ->addColumn(
                'fields',
                Table::TYPE_TEXT,
                '2M',
                [],
                'Product fields'
            )
            /** The timestamps */

            ->addColumn(
                'creation_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false],
                'Creation Time'
            )
            ->addColumn(
                'update_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false],
                'Update Time'
            )
            ->addIndex(
                $installer->getIdxName('entity_id', ['entity_id']),
                ['entity_id']
            )
            ->setComment('Eadesign Product feed Installer');

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
            $installer->getTable(self::STORE_TABLE)
        )->addColumn(
            'entity_id',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Product feed ID'
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addIndex(
            $installer->getIdxName(self::STORE_TABLE, ['store_id']),
            ['store_id']
        )->addForeignKey(
            $installer->getFkName(self::STORE_TABLE, 'entity_id', self::MAIN_TABLE, 'entity_id'),
            'entity_id',
            $installer->getTable(self::MAIN_TABLE),
            'entity_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(self::STORE_TABLE, 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        )->setComment(
            'Feed To Store Linkage Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}