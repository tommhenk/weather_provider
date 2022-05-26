<?php

declare(strict_types=1);

namespace Weather\Provider\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;


class ConfigWeatherParamsCities implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
            $res =
                [
                    [
                        'value' => '51.5073219,-0.1276474',
                        'label' => 'London',
                    ],
                    [
                        'value' => '48.8588897,2.320041',
                        'label' => 'Paris',
                    ],
                    [
                        'value' => '37.6377382,37.0383496',
                        'label' => 'Hambur',
                    ],
                    [
                        'value' => '59.9133301,10.7389701',
                        'label' => 'Oslo',
                    ],
                    [
                        'value' => '59.3253313,18.1003408',
                        'label' => 'Stockholm',
                    ],
                    [
                        'value' => '50.0229432,8.5249373',
                        'label' => 'Frankfurt',
                    ],
                    [
                        'value' => '59.3888548,24.6888639',
                        'label' => 'Kuiv',
                    ],
                    [
                        'value' => '52.2319581,21.0067249',
                        'label' => 'Warsaw',
                    ]
            ];


        return $res;
    }
}
