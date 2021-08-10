<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model\ResourceModel\ExternalEntity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Perspective\ExternalConnection\Model\ExternalEntity;
use Perspective\ExternalConnection\Model\ResourceModel\ExternalEntity as ResourceModel;
use Perspective\ExternalConnection\Model\ProcessingException;

/**
 * Simple External entity collection
 * We declare it as usual Collection. All connection magic is happened through di.xml configuration
 * Methods save() is overridden because external DB in this example must be immutable
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'external_entity_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ExternalEntity::class, ResourceModel::class);
    }

    /**
     * @return Collection<ExternalEntity>|void
     * @throws ProcessingException
     */
    public function save()
    {
        throw new ProcessingException(__('Save to External database is prohibited'));
    }
}
