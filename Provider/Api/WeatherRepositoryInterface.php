<?php
namespace Weather\Provider\Api;

use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Weather\Provider\Api\Data\WeatherInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Weather\Provider\Api\Data\WeatherSearchResultInterface;

/**
 * Interface WeatherRepositoryInterface
 * @package Weather\Provider
 * @api
 */
interface WeatherRepositoryInterface
{
    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): WeatherInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): WeatherSearchResultInterface;

    /**
     * @throws StateException
     */
    public function save(WeatherInterface $weather): WeatherInterface;

    /**
     * @throws StateException
     */
    public function delete(WeatherInterface $weather): bool;

    /**
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById(int $id): bool;
}
