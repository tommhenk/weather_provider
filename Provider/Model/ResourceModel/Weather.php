<?php

declare(strict_types=1);

namespace Weather\Provider\Model\ResourceModel;

use Weather\Provider\Api\Data\WeatherInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Weather
 * @package Weather\Provider\Model\ResourceModel
 */
class Weather extends AbstractDb
{
    /**
     * @var string
     */
    const TABLE_NAME = 'weather_provider';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, WeatherInterface::ID);
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getLastItemId()
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), 'entity_id')
            ->order('entity_id DESC');

        return $connection->fetchOne($select);

    }
}
