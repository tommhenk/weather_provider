<?php

declare(strict_types=1);

namespace Weather\Provider\Controller\Weather;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Controller\ResultFactory;
use Weather\Provider\Helper\PrepareDisplayedParameters;
use Weather\Provider\Model\WeatherRepository;
use Weather\Provider\Api\Data\WeatherInterface;

class Data extends Action
{
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private WeatherRepository $weatherRepository;
    private SortOrder $sortOrder;
    private PrepareDisplayedParameters $displayedParameters;

    /**
     * @param Context $context
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param WeatherRepository $weatherRepository
     * @param SortOrder $sortOrder
     * @param PrepareDisplayedParameters $displayedParameters
     */
    public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        WeatherRepository $weatherRepository,
        SortOrder $sortOrder,
        PrepareDisplayedParameters $displayedParameters
    ) {
        parent::__construct($context);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->weatherRepository = $weatherRepository;
        $this->sortOrder = $sortOrder;
        $this->displayedParameters = $displayedParameters;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $lastWeatherModel = $this->weatherRepository->getLastWeather();
        $weatherParams = $this->displayedParameters->getDisplayParameters($lastWeatherModel->getData());
//        foreach ($lastWeatherModel->getData() as $key => $item) {
//            $weatherParams[$key] = $item;
//        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($weatherParams);
        return $resultJson;
    }
}
