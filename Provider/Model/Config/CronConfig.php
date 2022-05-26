<?php

namespace Weather\Provider\Model\Config;

use Magento\Cron\Model\Config\Source\Frequency;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Validation\ValidationException;

class CronConfig extends Value
{
    const VALUE_FREQUENCY_DAY = 'non';
    const VALUE_FREQUENCY_HOUR = 'non';
    const CRON_STRING_PATH = 'crontab/default/jobs/weather_provider/schedule/cron_job';
    public static $frequencyPerDay;
    public static $frequencyPerHour;

    /**
     * @var ValueFactory
     */
    protected $_configValueFactory;

    /**
     * @var string
     */
    protected $_runModelPath = '';
    private ScopeConfigInterface $scopeConfig;
    private WriterInterface $configWriter;

    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        ValueFactory $configValueFactory,
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter,
        array $data = [],
        $runModelPath = ''
    ){
        $this->_runModelPath = $runModelPath;
        $this->_configValueFactory = $configValueFactory;

        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
        $this->scopeConfig = $scopeConfig;
        $this->configWriter = $configWriter;
    }

    public function beforeSave()
    {
        $cronExprArray = $this->createCronTimeArray();
        $cronExprString = join(' ', $cronExprArray);

        $this->configWriter->save(
            self::CRON_STRING_PATH,
            $cronExprString
        );

        return parent::beforeSave();
    }

    /**
     * @return array|string[]
     */
    private function createCronTimeArray()
    {
        $frequencyPerHourCalc = $this->getData('groups/frequency_update/fields/frequency_minutes/value');
        $frequencyPerDayCalc = $this->getData('groups/frequency_update/fields/frequency_day/value');
        self::$frequencyPerHour = $frequencyPerHourCalc;
        self::$frequencyPerDay = $frequencyPerDayCalc;
        $time = $this->getData('groups/frequency_update/fields/time/value');
        $frequency = $this->getData('groups/frequency_update/fields/frequency/value');

        if (self::VALUE_FREQUENCY_HOUR != $frequencyPerHourCalc){
            $cronExprArray = [
                "*/".self::$frequencyPerHour,
                "*",
                "*",
                "*",
                "*"
            ];
        } elseif (self::VALUE_FREQUENCY_DAY == $frequencyPerHourCalc) {
            $cronExprArray = [
                intval($time[1]),
                intval($time[0]),
                $frequency == Frequency::CRON_MONTHLY ? '1' : '*',
                "*",
                $frequency == Frequency::CRON_WEEKLY ? '1' : '*'
            ];
        } else {
            $cronExprArray = [
                0,
                "*/".self::$frequencyPerDay,
                "*",
                "*",
                "*"
            ];
        }
        return $cronExprArray;
    }
}
