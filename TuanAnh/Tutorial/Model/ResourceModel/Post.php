<?php

namespace TuanAnh\Tutorial\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
	protected $_storeManager;
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('tuananh_tutorial_post', 'post_id');
    }
}
