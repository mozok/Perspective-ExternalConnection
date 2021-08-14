<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Perspective\ExternalConnection\Model\ProcessingException;

/**
 * Another entity resource
 * We declare it as usual ResourceModel. All connection magic is happened through di.xml configuration
 * Methods save() and delete() are overridden because external DB in this example must be immutable
 */
class AnotherEntity extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'another_entity_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('another_entity', 'id');
        $this->_useIsObjectNew = true;
    }

    /**
     * @param AbstractModel $object
     * @return AnotherEntity|void
     * @throws ProcessingException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function save(AbstractModel $object)
    {
        throw new ProcessingException(__('Save to External database is prohibited'));
    }

    /**
     * @param AbstractModel $object
     * @return AnotherEntity|void
     * @throws ProcessingException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function delete(AbstractModel $object)
    {
        throw new ProcessingException(__('Delete from External database is prohibited'));
    }
}
