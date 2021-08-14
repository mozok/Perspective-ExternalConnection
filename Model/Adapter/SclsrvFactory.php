<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model\Adapter;

use Magento\Framework\App\DeploymentConfig;

class SclsrvFactory
{
    private const CONNECTION_CODE = 'db/connection/sqlsrv';

    /**
     * @var DeploymentConfig
     */
    protected $deploymentConfig;

    /**
     * @var \Zend_Db
     */
    protected $mssqlAdapterFactory;

    /**
     * @var \Zend_Db_Adapter_Abstract
     */
    protected $dbAdapter;

    /**
     * ConnectionManagement constructor.
     * @param \Zend_Db $mssqlAdapterFactory
     * @param DeploymentConfig $deploymentConfig
     */
    public function __construct(
        \Zend_Db $mssqlAdapterFactory,
        DeploymentConfig $deploymentConfig
    ) {
        $this->mssqlAdapterFactory = $mssqlAdapterFactory;
        $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * Create adapter for MsSQL connection
     *
     * @return \Zend_Db_Adapter_Abstract
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\R'table_prefix' => '',untimeException
     * @throws \Zend_Db_Exception
     */
    public function create()
    {
        if ($this->dbAdapter === null) {
            $connectionData = $this->deploymentConfig->get(self::CONNECTION_CODE);
            $this->dbAdapter = $this->mssqlAdapterFactory->factory('Sqlsrv', $connectionData);
        }

        return $this->dbAdapter;
    }
}
