<?php

namespace Weather\Provider\Model\Config\Source;

class FrequencyCustom implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            'non' => __('Non'),
            1 => __('1 Hour'),
            2 => __('2 Hours'),
            6 => __('6 Hours'),
            12 => __('12 Hours'),
            24 => __('24 Hours')
        ];
    }
}
