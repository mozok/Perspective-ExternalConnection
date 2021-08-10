<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Api;

use Perspective\ExternalConnection\Api\Data\ExternalEntityInterface;
use Perspective\ExternalConnection\Api\Data\ExternalEntitySearchResultsInterface;

/**
 * RepositoryInterface for another demonstration model
 * save() and delete() are not declared on purpose, as external DB in this example must be immutable
 */
interface ExternalEntityRepositoryInterface
{
    /**
     * Retrive ExternalEntity
     * @param int|string $entityId
     * @return \Perspective\ExternalConnection\Api\Data\ExternalEntityInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($entityId): ExternalEntityInterface;

    /**
     * Retrieve ExternalEntity matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Perspective\ExternalConnection\Api\Data\ExternalEntitySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): ExternalEntitySearchResultsInterface;
}
