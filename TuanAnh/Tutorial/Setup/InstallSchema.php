<?php

namespace TuanAnh\Tutorial\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /**
         * Create table 'tuananh_tutorial_post'
         */
        $table = $setup->getConnection()->newTable(
            $setup->getTable('tuananh_tutorial_post')
        )->addColumn(
            'post_id',
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true,],
            'Post ID'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Post Title'
        )->addColumn(
            'description',
			Table::TYPE_TEXT,
			'64k',
			[],
			'Post Description'
        )->addColumn(
        	'image',
			Table::TYPE_TEXT,
			255,
			[],
			'Post Image'
		)->addColumn(
			'status',
			Table::TYPE_INTEGER,
			1,
			[],
			'Post Status'
		)->addColumn(
			'store_id',
			Table::TYPE_INTEGER,
			null,
			[],
			'Store Id'
		)->addColumn(
			'observer',
			Table::TYPE_TEXT,
			255,
			[],
			'Observer'
		)->addColumn(
			'created_at',
			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
			'Created At'
		)->addColumn(
			'updated_at',
			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
			'Updated At'
		)->addIndex(
            $setup->getIdxName(
                $setup->getTable('tuananh_tutorial_post'),
                ['title'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Post Table'
        );

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
