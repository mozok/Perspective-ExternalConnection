<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model;

use Perspective\ExternalConnection\Api\ExternalEntityRepositoryInterface;

/**
 * Factory class for @see \Perspective\ExternalConnection\Model\ExternalEntityRepository
 */
class ExternalEntityRepositoryFactory implements RepositoryFactoryInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Instance name to create
     *
     * @var array<string, string>
     */
    protected $instanceNames = [];

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param array<string, string> $instanceNames
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $instanceNames = []
    ) {
        $this->objectManager = $objectManager;
        $this->instanceNames = $instanceNames;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param string $instanceCode
     * @param array<mixed> $data
     * @return ExternalEntityRepositoryInterface
     * @throws ProcessingException
     */
    public function create(string $instanceCode, array $data = []): ExternalEntityRepositoryInterface
    {
        if (!array_key_exists($instanceCode, $this->instanceNames)) {
            throw new ProcessingException(__('Undefined instance code'));
        }

        return $this->objectManager->create($this->instanceNames[$instanceCode], $data);
    }
}
