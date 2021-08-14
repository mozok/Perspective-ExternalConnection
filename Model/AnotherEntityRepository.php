<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Perspective\ExternalConnection\Api\Data\AnotherEntityInterface;
use Perspective\ExternalConnection\Api\Data\AnotherEntityInterfaceFactory;
use Perspective\ExternalConnection\Api\Data\AnotherEntitySearchResultsInterface;
use Perspective\ExternalConnection\Api\AnotherEntityRepositoryInterface;
use Perspective\ExternalConnection\Model\ResourceModel\AnotherEntity as AnotherEntityResource;
use Perspective\ExternalConnection\Model\ResourceModel\AnotherEntity\CollectionFactory;
use Perspective\ExternalConnection\Api\Data\AnotherEntitySearchResultsInterfaceFactory;
use Perspective\ExternalConnection\Model\ExternalRepositoryInterface;

/**
 * Another Entity repository
 * Same as usual Magento 2 Repository, except of getList() modification
 */
class AnotherEntityRepository implements AnotherEntityRepositoryInterface
{
    /**
     * @var AnotherEntityInterface[]
     */
    protected $instances = [];

    /**
     * @var AnotherEntityInterfaceFactory
     */
    private $anotherEntityFactory;

    /**
     * @var AnotherEntityResource
     */
    private $resource;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var AnotherEntitySearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    public function __construct(
        AnotherEntityInterfaceFactory $anotherEntityFactory,
        AnotherEntityResource $resource,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        AnotherEntitySearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->anotherEntityFactory = $anotherEntityFactory;
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     */
    public function get($entityId): AnotherEntityInterface
    {
        $entity = $this->anotherEntityFactory->create();
        if (!isset($this->instances[$entityId])) {
            $this->resource->load($entity, $entityId);
            if (!$entity->getId()) {
                throw new NoSuchEntityException(__('AnotherEntity with id "%1" does not exist.', $entityId));
            }
            $this->instances[$entityId] = $entity;
        }

        return $this->instances[$entityId];
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): AnotherEntitySearchResultsInterface
    {
        /**
         * If we configure Repositories as Virtual Types
         * we need to set our modified ResourceModel to collection
         */
        $collection = $this->collectionFactory->create(['resource' => $this->resource]);

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
