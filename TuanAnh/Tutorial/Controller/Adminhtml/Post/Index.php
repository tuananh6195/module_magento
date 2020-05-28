<?php

namespace TuanAnh\Tutorial\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('TuanAnh_Tutorial::post');
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('TuanAnh_Tutorial::post');
        $resultPage->getConfig()->getTitle()->prepend(__('Post'));

		$eventData = "Ra đi m";
		$this->_eventManager->dispatch('tuananh_tutorial_save_after',['myEventData'=>$eventData]);

        return $resultPage;
    }

//	public function execute()
//	{
//		$textDisplay = new \Magento\Framework\DataObject(array('text' => 'Mageplaza'));
//		$this->_eventManager->dispatch('tuananh_tutorial_post_prepare_save', ['mp_text' => $textDisplay]);
//		echo $textDisplay->getText();
//		exit;
//	}
}
