<?php

namespace Weather\Provider\Model\Config\Source;

class FrequencyMinutes implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            'non' => __('Non'),
            5 => __('5 Minutes'),
            10 => __('10 Minutes'),
            15 => __('15 Minutes'),
            20 => __('20 Minutes'),
            30 => __('30 Minutes')
        ];
    }
}
