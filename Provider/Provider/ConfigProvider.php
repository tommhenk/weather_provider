<?php

declare(strict_types=1);

namespace Weather\Provider\Provider;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider
{
    public const IS_ENABLED = 'weather/general/enabled';
    public const API_ENDPOINT = 'weather/general/api_endpoint';
    public const API_KEY = 'weather/general/api_key';
    public const WEATHER_CITY = 'weather/general/city';
    public const WEATHER_PARAMETERS = 'weather/general/parameters';
    public const WEATHER_USER = 'weather/general/api_user';
    public const WEATHER_PASSWORD = 'weather/general/api_password';
    public const WEATHER_CRON_CONFIG = 'crontab/default/jobs/weather_provider/schedule/cron_job';
    public const WEATHER_CRON_FREQUENCY_HOUR = 'weather/frequency_update/frequency_minutes';
    public const WEATHER_CRON_FREQUENCY_DAY = 'weather/frequency_update/frequency_day';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::IS_ENABLED);
    }

    public function getApiEndpoint(): ?string
    {
        return $this->scopeConfig->getValue(self::API_ENDPOINT);
    }

    public function getApiKey(): ?string
    {
        return $this->scopeConfig->getValue(self::API_KEY);
    }

    public function getCity(): ?string
    {
        return $this->scopeConfig->getValue(self::WEATHER_CITY);
    }

    public function getParameters(): ?string
    {
        return $this->scopeConfig->getValue(self::WEATHER_PARAMETERS);
    }

    public function getUser(): ?string
    {
        return $this->scopeConfig->getValue(self::WEATHER_USER);
    }

    public function getPassword(): ?string
    {
        return $this->scopeConfig->getValue(self::WEATHER_PASSWORD);
    }
    public function getCronConfig(): ?string
    {
        return $this->scopeConfig->getValue(self::WEATHER_CRON_CONFIG);
    }

    public function getFrequencyHour(): ?string
    {
        return $this->scopeConfig->getValue(self::WEATHER_CRON_FREQUENCY_HOUR);
    }

    public function getFrequencyDay(): ?string
    {
        return $this->scopeConfig->getValue(self::WEATHER_CRON_FREQUENCY_DAY);
    }
}
