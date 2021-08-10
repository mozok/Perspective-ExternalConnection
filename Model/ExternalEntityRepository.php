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
use Perspective\ExternalConnection\Api\Data\ExternalEntityInterface;
use Perspective\ExternalConnection\Api\Data\ExternalEntityInterfaceFactory;
use Perspective\ExternalConnection\Api\Data\ExternalEntitySearchResultsInterface;
use Perspective\ExternalConnection\Api\ExternalEntityRepositoryInterface;
use Perspective\ExternalConnection\Model\ResourceModel\ExternalEntity as ExternalEntityResource;
use Perspective\ExternalConnection\Model\ResourceModel\ExternalEntity\CollectionFactory;
use Perspective\ExternalConnection\Api\Data\ExternalEntitySearchResultsInterfaceFactory;

/**
 * External Entity repository
 * Same as usual Magento 2 Repository, except of getList() modification
 */
class ExternalEntityRepository implements ExternalEntityRepositoryInterface
{
    /**
     * @var ExternalEntityInterface[]
     */
    protected $instances = [];

    /**
     * @var ExternalEntityInterfaceFactory
     */
    private $externalEntityFactory;

    /**
     * @var ExternalEntityResource
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
     * @var ExternalEntitySearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    public function __construct(
        ExternalEntityInterfaceFactory $externalEntityFactory,
        ExternalEntityResource $resource,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ExternalEntitySearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->externalEntityFactory = $externalEntityFactory;
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     */
    public function get($entityId): ExternalEntityInterface
    {
        $entity = $this->externalEntityFactory->create();
        if (!isset($this->instances[$entityId])) {
            $this->resource->load($entity, $entityId);
            if (!$entity->getId()) {
                throw new NoSuchEntityException(__('ExternalEntity with id "%1" does not exist.', $entityId));
            }
            $this->instances[$entityId] = $entity;
        }

        return $this->instances[$entityId];
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ExternalEntitySearchResultsInterface
    {
        /**
         * We need to set our modified ResourceModel to collection
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
