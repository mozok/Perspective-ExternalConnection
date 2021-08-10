<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AnotherEntitySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get SeoText list.
     * @return \Perspective\ExternalConnection\Api\Data\AnotherEntityInterface[]
     */
    public function getItems(): array;

    /**
     * Set entity_id list.
     * @param \Perspective\ExternalConnection\Api\Data\AnotherEntityInterface[] $items
     * @return \Perspective\ExternalConnection\Api\Data\AnotherEntitySearchResultsInterface
     */
    public function setItems(array $items): AnotherEntitySearchResultsInterface;
}
