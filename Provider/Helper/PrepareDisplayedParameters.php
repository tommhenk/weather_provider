<?php

declare(strict_types=1);

namespace Weather\Provider\Helper;

use Magento\Framework\Serialize\Serializer\Json;
use Weather\Provider\Provider\ConfigProvider;

class PrepareDisplayedParameters
{
    private static $parameterNames = [
            'temperature'=>'Temperature C',
            'wind_dir'=>'Wind Direction',
            'wind_kph'=>'Wind Speed km/h',
            'humidity'=>'Humidity %',
            'precipitation'=>'Precipitation mm/day',
            'pressure'=>'Pressure Pa',
        ];

    private static $coreDataNameParameters = [
        't_2m:C'=>'temperature',
        'wind_speed_10m:kmh' => 'wind_kph',
        'wind_dir_10m:d'=>'wind_dir',
        'absolute_humidity_2m:gm3' => 'humidity',
        'precip_24h:mm'=>'precipitation',
        'msl_pressure:Pa'=>'pressure',
    ];
    private ConfigProvider $configProvider;
    private Json $json;

    /**
     * @param ConfigProvider $configProvider
     * @param Json $json
     */
    public function __construct(
        ConfigProvider $configProvider,
        Json $json
    ) {
        $this->configProvider = $configProvider;
        $this->json = $json;
    }

    /**
     * @param $items
     * @return array
     */
    public function getDisplayParameters($items): array
    {
        $allWeatherData = $this->prepareParameters($items);
        $displayedParameters = array_values(json_decode($this->configProvider->getParameters()));
        return $this->prepareFrontendResultParameters($displayedParameters, $allWeatherData);
    }

    /**
     * @param $displayedParameters
     * @param $allWeatherData
     * @return array
     */
    private function prepareFrontendResultParameters($displayedParameters, $allWeatherData): array
    {
        $resultParam = [];
        $resultParam['City'] = $allWeatherData['city'];
        foreach ($displayedParameters as $parameter) {
            $resultParam[self::$parameterNames[self::$coreDataNameParameters[$parameter]]] =
                $allWeatherData[self::$coreDataNameParameters[$parameter]];
        }
        return $resultParam;
    }

    /**
     * @param $items
     * @return array
     */
    private function prepareParameters($items): array
    {
        $weatherParams = [];
        foreach ($items as $key => $item) {
            $weatherParams[$key] = $item;
        }
        return $weatherParams;
    }
}
