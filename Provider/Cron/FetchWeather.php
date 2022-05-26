<?php

declare(strict_types=1);

namespace Weather\Provider\Cron;

use Magento\Framework\Exception\StateException;
use Psr\Log\LoggerInterface;
use Weather\Provider\Helper\PointCities;
use Weather\Provider\Model\WeatherRepository;
use Weather\Provider\Model\WeatherFactory;
use Weather\Provider\Model\WeatherDownloader;
use Weather\Provider\Provider\ConfigProvider;

class FetchWeather
{
    public static $weatherParams = [
        'current' => [
            't_2m:C'=>'temperature',
            'wind_speed_10m:kmh' => 'wind_kph',
            'wind_dir_10m:d'=>'wind_dir',
            'absolute_humidity_2m:gm3' => 'humidity',
            'precip_24h:mm'=>'precipitation',
            'msl_pressure:Pa'=>'pressure',
        ]
    ];

    private WeatherDownloader $weatherDownloader;

    private WeatherRepository $weatherRepository;

    private WeatherFactory $weatherFactory;

    private LoggerInterface $logger;

    private ConfigProvider $configProvider;

    private PointCities $paramsCities;

    public function __construct(
        WeatherDownloader $weatherManager,
        WeatherRepository $weatherRepository,
        WeatherFactory    $weatherFactory,
        LoggerInterface   $logger,
        ConfigProvider $configProvider,
        PointCities $paramsCities
    ) {
        $this->weatherDownloader = $weatherManager;
        $this->weatherRepository = $weatherRepository;
        $this->weatherFactory = $weatherFactory;
        $this->logger = $logger;
        $this->configProvider = $configProvider;
        $this->paramsCities = $paramsCities;
    }

    public function execute(): void
    {
        $data = $this->weatherDownloader->execute();
        $weatherData = $this->retrieveData($data);
        $weatherData['city'] = $this->paramsCities->getPointCityArray()[$weatherData['city']];

        if (is_array($weatherData)) {
            $weather = $this->weatherFactory->create();
            $weather->setData($weatherData);
            try {
                $this->weatherRepository->save($weather);
            } catch (StateException $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }

    private function retrieveData($data): array
    {
        $data = $this->prepareArray($data);
        $result = [];
        foreach (array_keys(self::$weatherParams['current']) as $param) {
            if (!empty($data[$param])) {
                $result[self::$weatherParams['current'][$param]] = $data[$param];
            }
        }
        $result['city'] = $this->configProvider->getCity();

        return $result;
    }

    private function prepareArray($data): array
    {
        $result = [];
        foreach ($data['data'] as $param) {
            $result[$param['parameter']] = $param['coordinates'][0]['dates'][0]['value'];
        }
        return $result;
    }
}
