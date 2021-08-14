<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Console\Command;

use Perspective\ExternalConnection\Model\Adapter\SclsrvFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to demonstrate usage of connection MsSQL DB
 */
class SclsrvConnection extends Command
{
    const TABLE_NAME = 'Kit';
    const ID_FIELD = 'ID';
    const NAME_FIELD = 'Name';
    const PRICE_FIELD = 'Price';

    /**
     * @var SclsrvFactory
     */
    private $sclsrvFactory;

    /**
     * @param SclsrvFactory $sclsrvFactory
     * @param string|null $name
     */
    public function __construct(
        SclsrvFactory $sclsrvFactory,
        string $name = null
    ) {
        parent::__construct($name);
        $this->sclsrvFactory = $sclsrvFactory;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('ps:sqlsrv:test');
        $this->setDescription('Testing MsSQL connection');
        parent::configure();
    }

    /**
     * Use Sqlsrv dbAdapter to load data from MsSQL DB
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\RuntimeException
     * @throws \Zend_Db_Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $kits = $this->loadKits();
        foreach ($kits as $kit) {
            $output->writeln(sprintf(
                'Load kit "%s", price: %s',
                $kit[self::NAME_FIELD],
                $kit[self::PRICE_FIELD]
            ));
        }

        return 0;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\RuntimeException
     * @throws \Zend_Db_Exception
     */
    private function loadKits()
    {
        $dbAdapter = $this->sclsrvFactory->create();
        $select = $dbAdapter->select()->from(
            [self::TABLE_NAME],
            [self::ID_FIELD, self::NAME_FIELD, self::PRICE_FIELD]
        );

        return $dbAdapter->fetchAll($select);
    }
}
