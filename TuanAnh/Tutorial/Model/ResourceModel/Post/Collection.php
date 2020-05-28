<?php

namespace TuanAnh\Tutorial\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'post_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('TuanAnh\Tutorial\Model\Post', 'TuanAnh\Tutorial\Model\ResourceModel\Post');
    }
}
