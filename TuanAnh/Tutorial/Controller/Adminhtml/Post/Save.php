<?php

namespace TuanAnh\Tutorial\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use TuanAnh\Tutorial\Model\PostFactory;

class Save extends Action
{
    /** @var PostFactory $objectFactory */
    protected $objectFactory;
	protected $_eventManager;
    /**
     * @param Context $context
     * @param PostFactory $objectFactory
     */
    public function __construct(
        Context $context,
        PostFactory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('TuanAnh_Tutorial::post');
    }

	protected function filePreprocessing($data)
	{
		if (isset($data['image'])) {
			$data['image'] = $data['image'][0]['name'];
		} else {
			$data['image'] = null;
		}
		return $data;
	}
	protected function saveStore($data)
	{
		if ($data['store_id'][0] != 0 ){
			$data['store_id'] = $data['store_id'][0];
		} else {
			$data['store_id'] = 1;
		}
		return $data;
	}
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $data = $this->filePreprocessing($data);
        $data = $this->saveStore($data);
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $objectInstance = $this->objectFactory->create();
            $idField = $objectInstance->getIdFieldName();
            if (empty($data[$idField])) {
                $data[$idField] = null;
            } else {
                $objectInstance->load($data[$idField]);
                $params[$idField] = $data[$idField];
            }
            $objectInstance->addData($data);

            try {
                $objectInstance->save();
				$this->_eventManager->dispatch(
					'tuananh_tutorial_post_after_save',
					['object' => $data['post_id'], 'request' => $this->getRequest()]
				);
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params = [$idField => $objectInstance->getId(), '_current' => true];
                    return $resultRedirect->setPath('*/*/edit', $params);
                }
                return $resultRedirect->setPath('*/*/');

            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the record.'));
            }

            $this->_getSession()->setFormData($this->getRequest()->getPostValue());

            return $resultRedirect->setPath('*/*/edit', $params);

        }
        return $resultRedirect->setPath('*/*/');
    }
}
