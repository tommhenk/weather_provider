<?php

declare(strict_types=1);

namespace Weather\Provider\Model\Config\Backend;

/**
 * class WeatherParameters
 */
class WeatherParameters extends \Magento\Config\Model\Config\Backend\Serialized\ArraySerialized
{
    /**
     * @return WeatherParameters
     */
   public function beforeSave(): WeatherParameters
   {
       return parent::beforeSave();
   }

}
