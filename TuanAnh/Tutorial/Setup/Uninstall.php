<?php

namespace TuanAnh\Tutorial\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($setup->tableExists('tuananh_tutorial_post')) {
            $setup->getConnection()->dropTable($setup->getTable('tuananh_tutorial_post'));
        }

        $setup->endSetup();
    }
}
