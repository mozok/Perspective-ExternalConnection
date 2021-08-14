<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model;

use Perspective\ExternalConnection\Api\ExternalRepositoryInterface;

/**
 * Abstract factory for Repositories
 */
interface RepositoryFactoryInterface
{
    /**
     * Create class instance with specified parameters
     *
     * @param string $instanceCode
     * @param array<mixed> $data
     * @return ExternalRepositoryInterface
     * @throws ProcessingException
     */
    public function create(string $instanceCode, array $data = []): ExternalRepositoryInterface;
}
