<?php

namespace Weather\Provider\Helper;

use Weather\Provider\Model\Config\Source\ConfigWeatherParamsCities;

class PointCities
{
    private ConfigWeatherParamsCities $paramsCities;

    /**
     * @param ConfigWeatherParamsCities $paramsCities
     */
    public function __construct(ConfigWeatherParamsCities $paramsCities)
    {
        $this->paramsCities = $paramsCities;
    }

    /**
     * @return array
     */
    public function getPointCityArray(): array
    {
        $resultArray = [];
        foreach ($this->paramsCities->toOptionArray() as $item) {
            $resultArray[$item['value']] = $item['label'];
        }
        return $resultArray;
    }

}
