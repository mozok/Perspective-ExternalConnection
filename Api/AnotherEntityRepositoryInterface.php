<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Api;

use Perspective\ExternalConnection\Api\Data\AnotherEntityInterface;
use Perspective\ExternalConnection\Api\Data\AnotherEntitySearchResultsInterface;

/**
 * RepositoryInterface for external model
 * save() and delete() are not declared on purpose, as external DB in this example must be immutable
 */
interface AnotherEntityRepositoryInterface extends ExternalRepositoryInterface
{
    /**
     * Retrive AnotherEntity
     * @param int|string $categoryId
     * @return \Perspective\ExternalConnection\Api\Data\AnotherEntityInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($categoryId): AnotherEntityInterface;

    /**
     * Retrieve AnotherEntity matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Perspective\ExternalConnection\Api\Data\AnotherEntitySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );
}
