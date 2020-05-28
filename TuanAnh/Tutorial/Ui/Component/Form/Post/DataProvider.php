<?php

namespace TuanAnh\Tutorial\Ui\Component\Form\Post;

use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Store\Model\StoreManagerInterface;
use TuanAnh\Tutorial\Model\ResourceModel\Post\Collection;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;
    
    /**
     * @var FilterPool
     */
    protected $filterPool;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Collection $collection
     * @param FilterPool $filterPool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        FilterPool $filterPool,
		StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->filterPool = $filterPool;
		$this->storeManager = $storeManager;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->loadedData) {
            $items = $this->collection->getItems();
            foreach ($items as $item) {
				if ($item->getImage()) {
					$m['image'][0]['name'] = $item->getImage();
					$m['image'][0]['url'] = $this->getMediaUrl().$item->getImage();
					$this->loadedData[$item->getId()] = array_merge($item->getData(), $m);
				} else {
					$this->loadedData[$item->getId()] = $item->getData();
				}
                break;
            }
        }
        return $this->loadedData;
    }
	public function getMediaUrl()
	{
		$mediaUrl = $this->storeManager->getStore()
				->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'tuananh_tutorial/files/tmp/';
		return $mediaUrl;
	}
}
