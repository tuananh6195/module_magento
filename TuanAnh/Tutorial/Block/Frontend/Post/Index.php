<?php
	namespace TuanAnh\Tutorial\Block\Frontend\Post;

	use Magento\Store\Model\StoreManagerInterface;

	class Index extends \Magento\Framework\View\Element\Template
	{
		protected $_rewardCollection;

		public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\TuanAnh\Tutorial\Model\PostFactory $postFactory,
			StoreManagerInterface $storeManager
		)
		{
			$this->_rewardCollection = $postFactory;
			$this->storeManager = $storeManager;
			parent::__construct($context);
		}

		protected function _prepareLayout()
		{

			parent::_prepareLayout();
			$this->pageConfig->getTitle()->set(__('List Post Frontend'));

			if ($this->getRewardHistory()) {
				$pager = $this->getLayout()->createBlock(
					'Magento\Theme\Block\Html\Pager',
					'index.history.pager'
				)->setAvailableLimit(array(5 => 5, 10 => 10, 15 => 15, 20 => 20))
					->setShowPerPage(true)->setCollection(
						$this->getRewardHistory()
					);
				$this->setChild('pager', $pager);
				$this->getRewardHistory()->load();
			}
			return $this;
		}

		public function getPagerHtml()
		{
			return $this->getChildHtml('pager');
		}

		/**
		 * function to get rewards point transaction of customer
		 *
		 * @return reward transaction collection
		 */
		Public function getRewardHistory()
		{
			//get values of current page
			$page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
			//get values of current limit
			$pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest
			()->getParam('limit') : 5;
			$storeV = $this->getStore();
			$post = $this->_rewardCollection->create();
			$collection = $post->getCollection()->addFilter('store_id', $storeV, 'and') ->addFilter('status', 1);
			$collection->setPageSize($pageSize);
			$collection->setCurPage($page);

			return $collection;
		}

		Public function getCountPost(){
			$storeV = $this->getStore();
			$post = $this->_rewardCollection->create();
			$collection = $post->getCollection();
			$collection->getItemByColumnValue('store_id', $storeV);
			return $collection;
		}


		public function getStore(){
			$storeView = ($this->getRequest()->getParam('___store')) ? $this->getRequest()->getParam('___store') : 'default';
			$store = null;
			if ($storeView === 'vi'){
				$store = 3;
			} elseif ($storeView === 'en'){
				$store = 2;
			} else {
				$store = 1;
			}
			return $store;
		}

		public function getMediaUrl()
		{
			$mediaUrl = $this->storeManager->getStore()
					->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'tuananh_tutorial/files/tmp/';
			return $mediaUrl;
		}
	}
