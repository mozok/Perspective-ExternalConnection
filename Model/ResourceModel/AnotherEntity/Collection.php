<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model\ResourceModel\AnotherEntity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Perspective\ExternalConnection\Model\AnotherEntity;
use Perspective\ExternalConnection\Model\ResourceModel\AnotherEntity as ResourceModel;
use Perspective\ExternalConnection\Model\ProcessingException;

/**
 * Another entity collection
 * We declare it as usual Collection. All connection magic is happened through di.xml configuration
 * Methods save() is overridden because external DB in this example must be immutable
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'another_entity_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(AnotherEntity::class, ResourceModel::class);
    }

    /**
     * @return Collection<AnotherEntity>|void
     * @throws ProcessingException
     */
    public function save()
    {
        throw new ProcessingException(__('Save to External database is prohibited'));
    }
}
