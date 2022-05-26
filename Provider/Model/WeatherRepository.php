<?php

declare(strict_types=1);

namespace Weather\Provider\Model;

use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Weather\Provider\Api\Data\WeatherInterface;
use \Magento\Framework\Api\SearchResults;
use Weather\Provider\Api\Data\WeatherSearchResultInterface;
use Weather\Provider\Model\Weather;
use Weather\Provider\Api\Data\WeatherInterfaceFactory;
use Weather\Provider\Model\ResourceModel\Weather as WeatherResource;
use Weather\Provider\Model\ResourceModel\Weather\CollectionFactory as WeatherCollectionFactory;
use Weather\Provider\Api\Data\WeatherSearchResultInterfaceFactory;
use Psr\Log\LoggerInterface;

class WeatherRepository implements \Weather\Provider\Api\WeatherRepositoryInterface
{
    /**
     * @var array
     */
    private $registry = [];
    private WeatherInterfaceFactory $weatherFactory;
    private WeatherResource $weatherResource;
    private WeatherSearchResultInterfaceFactory $searchResultFactory;
    private CollectionProcessor $collectionProcessor;
    private WeatherCollectionFactory $weatherCollection;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private SortOrder $sortOrder;
    private LoggerInterface $logger;

    /**
     * @param WeatherInterfaceFactory $weatherFactory
     * @param WeatherResource $weatherResource
     * @param WeatherCollectionFactory $weatherCollection
     * @param WeatherSearchResultInterfaceFactory $searchResultFactory
     * @param CollectionProcessor $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrder $sortOrder
     * @param LoggerInterface $logger
     */
    public function __construct(
        WeatherInterfaceFactory $weatherFactory,
        WeatherResource $weatherResource,
        WeatherCollectionFactory $weatherCollection,
        WeatherSearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessor $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrder $sortOrder,
        LoggerInterface $logger
    ) {

        $this->weatherFactory = $weatherFactory;
        $this->weatherResource = $weatherResource;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->weatherCollection = $weatherCollection;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrder = $sortOrder;
        $this->logger = $logger;
    }

    /**
     * @param int $id
     * @return WeatherInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): WeatherInterface
    {
        if (!array_key_exists($id, $this->registry)) {
            $weatherModel = $this->weatherFactory->create();
            $weatherModel->load($id);
            if (!$weatherModel->getId()) {
                throw new NoSuchEntityException(__('Requested data does not exist'));
            }
            $this->registry[$id] = $weatherModel;
        }
        return $this->registry[$id];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return WeatherSearchResultInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): WeatherSearchResultInterface
    {
        try {
            $collection = $this->weatherCollection->create();
            $this->collectionProcessor->process($searchCriteria, $collection);

            $searchResults = $this->searchResultFactory->create();
            $searchResults->setItems($collection->getItems());
            $searchResults->setSearchCriteria($searchCriteria);
            $searchResults->setTotalCount($collection->getSize());

            return $searchResults;
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            throw new LocalizedException(__('Could not retrieve assets.'), $exception);
        }
    }

    /**
     * @param WeatherInterface $weather
     * @return WeatherInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(WeatherInterface $weather): WeatherInterface
    {
        $this->weatherResource->save($weather);
        return $weather;
    }

    /**
     * @param WeatherInterface $weather
     * @return bool
     * @throws \Exception
     */
    public function delete(WeatherInterface $weather): bool
    {
        $this->weatherResource->delete($weather);
        return (bool)$weather->getId();
    }

    /**
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        $weatherModel = $this->getById($id);
        $this->weatherResource->delete($weatherModel);
        return (bool)$weatherModel->getId();
    }

    /**
     * @return WeatherInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getLastWeather(): WeatherInterface
    {
//        $sortOrder = $this->sortOrder->setField(WeatherInterface::ID)
//            ->setDirection(SortOrder::SORT_DESC);
//        $searchCriteriaResult = $this->searchCriteriaBuilder->create();
//        $searchCriteriaResult->setSortOrders([$sortOrder]);
//        $searchCriteriaResult->setPageSize(1);
//        $res = $this->getList($searchCriteriaResult);
//
//        $weatherModels = $res->getItems();
//        reset($weatherModels);
//        return current($weatherModels);
        return $this->getById(
            (int)$this->weatherResource->getLastItemId()
        );
    }
}
