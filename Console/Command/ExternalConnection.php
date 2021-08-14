<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Console\Command;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Perspective\ExternalConnection\Api\AnotherEntityRepositoryInterface;
use Perspective\ExternalConnection\Api\Data\AnotherEntityInterface;
use Perspective\ExternalConnection\Api\Data\ExternalEntityInterface;
use Perspective\ExternalConnection\Api\ExternalEntityRepositoryInterface;
use Perspective\ExternalConnection\Model\AnotherEntityRepositoryFactory;
use Perspective\ExternalConnection\Model\ExternalEntityRepositoryFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to demonstrate usage of external connection repository factories
 */
class ExternalConnection extends Command
{
    const CONNECTION_CODE_DB1 = 'db1';
    const CONNECTION_CODE_DB2 = 'db2';

    /**
     * @var ExternalEntityRepositoryFactory
     */
    private $externalEntityRepositoryFactory;

    /**
     * @var AnotherEntityRepositoryFactory
     */
    private $anotherEntityRepositoryFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param ExternalEntityRepositoryFactory $externalEntityRepositoryFactory
     * @param AnotherEntityRepositoryFactory $anotherEntityRepositoryFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param string|null $name
     */
    public function __construct(
        ExternalEntityRepositoryFactory $externalEntityRepositoryFactory,
        AnotherEntityRepositoryFactory $anotherEntityRepositoryFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        string $name = null
    ) {
        parent::__construct($name);
        $this->externalEntityRepositoryFactory = $externalEntityRepositoryFactory;
        $this->anotherEntityRepositoryFactory = $anotherEntityRepositoryFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('ps:external:test');
        $this->setDescription('Testing external connection repository factory');
        parent::configure();
    }

    /**
     * Perform actions with several connections
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Perspective\ExternalConnection\Model\ProcessingException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /**
         * Prepare Repository, load entities and pass it to business logic method
         */
        $repoDb1 = $this->externalEntityRepositoryFactory->create(self::CONNECTION_CODE_DB1);
        $entities = $this->getExternalEntities($repoDb1);
        $this->processExternalEntities($entities, $output);

        $repoDb2 = $this->externalEntityRepositoryFactory->create(self::CONNECTION_CODE_DB2);
        $entities = $this->getExternalEntities($repoDb2);
        $this->processExternalEntities($entities, $output);

        /**
         * Repeat for every entity
         */
        $repoDb1 = $this->anotherEntityRepositoryFactory->create(self::CONNECTION_CODE_DB1);
        $entities = $this->getAnotherEntities($repoDb1);
        $this->processAnotherEntities($entities, $output);

        $repoDb2 = $this->anotherEntityRepositoryFactory->create(self::CONNECTION_CODE_DB2);
        $entities = $this->getAnotherEntities($repoDb2);
        $this->processAnotherEntities($entities, $output);

        return 0;
    }

    /**
     * @param ExternalEntityRepositoryInterface $externalRepository
     * @return ExternalEntityInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getExternalEntities(ExternalEntityRepositoryInterface $externalRepository)
    {
        return $externalRepository->getList($this->getSearchCriteria())->getItems();
    }

    /**
     * Business logic for your ExternalEntityInterface
     *
     * @param ExternalEntityInterface[] $externalEntities
     * @param OutputInterface $output
     */
    private function processExternalEntities(array $externalEntities, OutputInterface $output): void
    {
        foreach ($externalEntities as $entity) {
            $output->writeln("External entity data field: " . $entity->getDataField());
        }
    }

    /**
     * @param AnotherEntityRepositoryInterface $anotherRepository
     * @return AnotherEntityInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getAnotherEntities(AnotherEntityRepositoryInterface $anotherRepository)
    {
        return $anotherRepository->getList($this->getSearchCriteria())->getItems();
    }

    /**
     * Business logic for your AnotherEntityInterface
     *
     * @param AnotherEntityInterface[] $anotherEntities
     * @param OutputInterface $output
     */
    private function processAnotherEntities(array $anotherEntities, OutputInterface $output): void
    {
        foreach ($anotherEntities as $entity) {
            $output->writeln("Another Id loaded: " . $entity->getId());
        }
    }

    /**
     * @return SearchCriteria
     */
    private function getSearchCriteria(): SearchCriteria
    {
        return $this->searchCriteriaBuilder->create();
    }
}
