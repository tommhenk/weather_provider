<?php

declare(strict_types=1);

namespace Weather\Provider\Model;

use Weather\Provider\Api\Data\WeatherInterface;
use Weather\Provider\Model\ResourceModel\Weather as WeatherResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Weather
 * @package Weather\Lublin\Model
 */
class Weather extends AbstractModel implements WeatherInterface
{
    protected $_idFieldName = WeatherInterface::ID;

    protected function _construct()
    {
        $this->_init(WeatherResource::class);
    }

    public function getCountry(): string
    {
        return $this->getData(WeatherInterface::COUNTRY);
    }

    public function setCountry(string $country): WeatherInterface
    {
        return $this->setData(WeatherInterface::COUNTRY, $country);
    }

    public function getCity(): string
    {
        return $this->getData(WeatherInterface::CITY);
    }

    public function setCity(string $city): WeatherInterface
    {
        return $this->setData(WeatherInterface::CITY, $city);
    }

    public function getTemperature(): float
    {
        return $this->getData(WeatherInterface::TEMPERATURE);
    }

    public function setTemperature(float $temperature): self
    {
        return $this->setData(WeatherInterface::TEMPERATURE, $temperature);
    }

    public function getPrecipitation(): float
    {
        return $this->getData(WeatherInterface::PRECIPITATION);
    }

    public function setPrecipitation(float $precipitation): WeatherInterface
    {
        return $this->setData(WeatherInterface::PRECIPITATION, $precipitation);
    }

    public function getHumidity(): float
    {
        return $this->getData(WeatherInterface::HUMIDITY);
    }

    public function setHumidity(float $humidity): WeatherInterface
    {
        return $this->setData(WeatherInterface::HUMIDITY, $humidity);
    }

    public function getWindKph(): float
    {
        return $this->getData(WeatherInterface::WIND_KPH);
    }

    public function setWindKph(float $windKph): WeatherInterface
    {
        return $this->setData(WeatherInterface::WIND_KPH, $windKph);
    }

    public function getWindDir(): string
    {
        return $this->getData(WeatherInterface::WIND_DIR);
    }

    public function setWindDir(string $windDir): WeatherInterface
    {
        return $this->setData(WeatherInterface::WIND_DIR, $windDir);
    }

    public function getTimestamp(): string
    {
        return $this->getData(WeatherInterface::TIMESTAMP);
    }

    public function setTimestamp(string $timestamp): WeatherInterface
    {
        return $this->setData(WeatherInterface::TIMESTAMP, $timestamp);
    }
}

