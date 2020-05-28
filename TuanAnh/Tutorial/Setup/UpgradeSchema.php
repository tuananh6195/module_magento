<?php

	namespace TuanAnh\Tutorial\Setup;


	use Magento\Framework\Setup\ModuleContextInterface;
	use Magento\Framework\Setup\SchemaSetupInterface;
	use Magento\Framework\Setup\UpgradeSchemaInterface;

	class UpgradeSchema implements UpgradeSchemaInterface
	{

		/**
		 * Upgrades DB schema for a module
		 *
		 * @param SchemaSetupInterface $setup
		 * @param ModuleContextInterface $context
		 * @return void
		 */
		public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
		{
			$setup->startSetup();


		}
	}