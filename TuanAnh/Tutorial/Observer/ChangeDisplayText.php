<?php

	namespace TuanAnh\Tutorial\Observer;

	use TuanAnh\Tutorial\Model\PostFactory;
	use Magento\Framework\Stdlib\DateTime\DateTime;

	class ChangeDisplayText implements \Magento\Framework\Event\ObserverInterface
	{
		protected $objectFactory;
		protected $datetime;

		public function __construct(PostFactory $objectFactory, DateTime $dateTime){
			$this->objectFactory = $objectFactory;
			$this->datetime = $dateTime;
		}

		public function execute(\Magento\Framework\Event\Observer $observer)
		{
			$model=$this->objectFactory->create();
			$data = $observer->getData('object');
			if ($data == null){
				$new = $model->getCollection()->getLastItem()->getData();
				$model->load($new['post_id'])->setOb('Create at: ' . $this->datetime->gmtDate('d-m-Y h:i:s \G\M\T'))->save();
			} else {
				$model->load($data)->setOb('Update at: ' . $this->datetime->gmtDate('d-m-Y h:i:s \G\M\T'))->save();
			}
			return $this;
		}
	}