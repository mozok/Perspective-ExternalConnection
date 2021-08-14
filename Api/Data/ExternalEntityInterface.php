<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Api\Data;

/**
 * Simple data interface for external model, just for demonstration
 */
interface ExternalEntityInterface
{
    /**
     * String constants for property names
     */
    const ID = 'id';
    const DATA_FIELD = 'data_field';

    /**
     * Getter for ID
     * @return int|string
     */
    public function getId();

    /**
     * Setter for ID
     * @param int|string $entityId
     * @return \Perspective\ExternalConnection\Api\Data\ExternalEntityInterface
     */
    public function setId($entityId);

    /**
     * Getter for data_field
     * @return string
     */
    public function getDataField(): string;

    /**
     * Setter for data_field
     * @param string $dataField
     * @return \Perspective\ExternalConnection\Api\Data\ExternalEntityInterface
     */
    public function setDataField(string $dataField): ExternalEntityInterface;
}
