<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model;

use Magento\Framework\Model\AbstractModel;
use Perspective\ExternalConnection\Api\Data\ExternalEntityInterface;
use Perspective\ExternalConnection\Model\ResourceModel\ExternalEntity as ResourceModel;

/**
 * Simple External entity
 */
class ExternalEntity extends AbstractModel implements ExternalEntityInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'external_entity_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return (int)$this->getData(self::ID);
    }

    /**
     * @inheritdoc
     */
    public function setId(int $entityId): ExternalEntityInterface
    {
        return $this->setData(self::ID, $entityId);
    }

    /**
     * @inheritdoc
     */
    public function getDataField(): string
    {
        return $this->getData(self::DATA_FIELD);
    }

    /**
     * @inheritdoc
     */
    public function setDataField(string $dataField): ExternalEntityInterface
    {
        return $this->setData(self::DATA_FIELD, $dataField);
    }
}
