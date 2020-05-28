<?php

namespace TuanAnh\Tutorial\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Tuananh\Tutorial\Api\Data\GridInterface;

class Post extends AbstractModel implements IdentityInterface, GridInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'tuananh_tutorial_post';

    /**
     * @var string
     */
    protected $_cacheTag = 'tuananh_tutorial_post';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'tuananh_tutorial_post';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('TuanAnh\Tutorial\Model\ResourceModel\Post');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function setOb($ob){
		return $this->setData(self::OBSERVER, $ob);
	}

    /**
     * Save from collection data
     *
     * @param array $data
     * @return $this|bool
     */
    public function saveCollection(array $data)
    {
        if (isset($data[$this->getId()])) {
            $this->addData($data[$this->getId()]);
            $this->getResource()->save($this);
        }
        return $this;
    }
}
