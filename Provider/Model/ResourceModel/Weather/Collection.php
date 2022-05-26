<?php
namespace Weather\Provider\Model\ResourceModel\Weather;

use Weather\Provider\Model\Weather;
use Weather\Provider\Model\ResourceModel\Weather as WeatherResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Weather\Lublin\Model\ResourceModel\Weather
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Weather::class, WeatherResource::class);
    }
}
