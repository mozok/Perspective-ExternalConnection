<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ExternalEntitySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get SeoText list.
     * @return \Perspective\ExternalConnection\Api\Data\ExternalEntityInterface[]
     */
    public function getItems(): array;

    /**
     * Set entity_id list.
     * @param \Perspective\ExternalConnection\Api\Data\ExternalEntityInterface[] $items
     * @return \Perspective\ExternalConnection\Api\Data\ExternalEntitySearchResultsInterface
     */
    public function setItems(array $items): ExternalEntitySearchResultsInterface;
}
