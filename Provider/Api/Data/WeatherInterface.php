<?php

declare(strict_types=1);

namespace Weather\Provider\Api\Data;

/**
 * Interface WeatherInterface
 * @package  Weather\Provider\Api\Data
 * @api
 */
interface WeatherInterface
{
    /**#@+
     * Constants
     * @var string
     */
    public const ID = 'entity_id';
    public const CITY = 'city';
    public const COUNTRY = 'country';
    public const TEMPERATURE = 'temperature';
    public const PRECIPITATION = 'precipitation';
    public const PRESSURE = 'pressure';
    public const HUMIDITY = 'humidity';
    public const WIND_KPH = 'wind_kph';
    public const WIND_DIR = 'wind_dir';
    public const TIMESTAMP = 'timestamp';
    /**#@-*/

    public function getCountry(): string;

    public function setCountry(string $country): self;

    public function getCity(): string;

    public function setCity(string $city): self;

    public function getTemperature(): float;

    public function setTemperature(float $temperature): self;

    public function getPrecipitation(): float;

    public function setPrecipitation(float $precipitation): self;

    public function getHumidity(): float;

    public function setHumidity(float $humidity): self;

    public function getWindKph(): float;

    public function setWindKph(float $windKph): self;

    public function getWindDir(): string;

    public function setWindDir(string $windDir): self;

    public function getTimestamp(): string;

    public function setTimestamp(string $timestamp): self;
}
