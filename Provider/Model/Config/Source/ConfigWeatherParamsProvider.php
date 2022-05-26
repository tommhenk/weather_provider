<?php

declare(strict_types=1);

namespace Weather\Provider\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;


class ConfigWeatherParamsProvider implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
            $res =
                [
                    [
                        'value' => 't_2m:C',
                        'label' => 'Temperature C',
                    ],
                    [
                        'value' => 'wind_speed_10m:kmh',
                        'label' => 'Wind km/h',
                    ],
                    [
                        'value' => 'wind_dir_10m:d',
                        'label' => 'Wind Direction',
                    ],
                    [
                        'value' => 'absolute_humidity_2m:gm3',
                        'label' => 'Humidity',
                    ],
                    [
                        'value' => 'precip_24h:mm',
                        'label' => 'Precipitation mm',
                    ],
                    [
                        'value' => 'msl_pressure:Pa',
                        'label' => 'Pressure Pa',
                    ]
            ];


        return $res;
    }
}
