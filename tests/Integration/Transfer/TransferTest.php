<?php

namespace App\Tests\Integration\Transfer;

use App\Application\Command\TransferCommand;
use App\Application\CommandHandler\CreateTransferCommandHandler;
use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Domain\Exception\InsufficientFundsException;
use App\Domain\Exception\InvalidPayerTypeException;
use App\Domain\Exception\InvalidValueTransferException;
use App\Domain\Exception\TransferSameUserException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Persistence\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransferTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $this->truncateEntities([User::class]);

        $loader = new Loader();
        $loader->addFixture(new UserFixtures);

        $purger = new ORMPurger($entityManager);
        $executor = new ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    public function testSuccessTransfer()
    {
        $container = static::getContainer();
        $userRepository = $container->get(UserRepositoryInterface::class);

        $payerId = 1;
        $payeeId = 2;

        $payer = $userRepository->get($payerId);
        $payee = $userRepository->get($payeeId);

        $payerBalance = $payer->getBalance();
        $payeeBalance = $payee->getBalance();

        $transferCommand = new TransferCommand([
            'payer' => $payerId,
            'payee' => $payeeId,
            'value' => 100
        ]);

        /** @var CreateTransferCommandHandler $createTransferCommandHandler */
        $createTransferCommandHandler = $container->get(CreateTransferCommandHandler::class);
        $transfer = $createTransferCommandHandler->execute($transferCommand);

        self::assertInstanceOf(User::class, $transfer->getPayer());
        self::assertInstanceOf(User::class, $transfer->getPayee());
        self::assertEquals(Transfer::APPROVED, $transfer->getStatus());
        self::assertEquals($transfer->getPayer()->getBalance(), $payerBalance - $transfer->getValue());
        self::assertEquals($transfer->getPayee()->getBalance(), $payeeBalance + $transfer->getValue());
    }

    public function testMissingPayerTransfer()
    {
        self::expectException(\Exception::class);

        $container = static::getContainer();

        $payeeId = 2;
        $transferCommand = new TransferCommand([
            'payee' => $payeeId,
            'value' => 100
        ]);

        /** @var CreateTransferCommandHandler $createTransferCommandHandler */
        $createTransferCommandHandler = $container->get(CreateTransferCommandHandler::class);
        $createTransferCommandHandler->execute($transferCommand);
    }

    public function testMissingPayeeTransfer()
    {
        self::expectException(\Exception::class);

        $container = static::getContainer();

        $payerId = 1;
        $transferCommand = new TransferCommand([
            'payer' => $payerId,
            'value' => 100
        ]);

        /** @var CreateTransferCommandHandler $createTransferCommandHandler */
        $createTransferCommandHandler = $container->get(CreateTransferCommandHandler::class);
        $createTransferCommandHandler->execute($transferCommand);
    }

    public function testMissingVolumeTransfer()
    {
        self::expectException(InvalidValueTransferException::class);

        $container = static::getContainer();

        $payerId = 1;
        $payeeId = 2;

        $transferCommand = new TransferCommand([
            'payer' => $payerId,
            'payee' => $payeeId,
        ]);

        /** @var CreateTransferCommandHandler $createTransferCommandHandler */
        $createTransferCommandHandler = $container->get(CreateTransferCommandHandler::class);
        $createTransferCommandHandler->execute($transferCommand);
    }

    public function testSameUserTransfer()
    {
        self::expectException(TransferSameUserException::class);

        $container = static::getContainer();

        $payerId = 1;
        $payeeId = 1;

        $transferCommand = new TransferCommand([
            'payer' => $payerId,
            'payee' => $payeeId,
            'value' => 100
        ]);

        /** @var CreateTransferCommandHandler $createTransferCommandHandler */
        $createTransferCommandHandler = $container->get(CreateTransferCommandHandler::class);
        $createTransferCommandHandler->execute($transferCommand);
    }

    public function testInsufficientFundsTransfer()
    {
        self::expectException(InsufficientFundsException::class);

        $container = static::getContainer();

        $payerId = 1;
        $payeeId = 1;

        $transferCommand = new TransferCommand([
            'payer' => $payerId,
            'payee' => $payeeId,
            'value' => 250
        ]);

        /** @var CreateTransferCommandHandler $createTransferCommandHandler */
        $createTransferCommandHandler = $container->get(CreateTransferCommandHandler::class);
        $createTransferCommandHandler->execute($transferCommand);
    }

    public function testShopkeeperTransfer()
    {
        self::expectException(InvalidPayerTypeException::class);

        $container = static::getContainer();

        $payerId = 3;
        $payeeId = 1;

        $transferCommand = new TransferCommand([
            'payer' => $payerId,
            'payee' => $payeeId,
            'value' => 250
        ]);

        /** @var CreateTransferCommandHandler $createTransferCommandHandler */
        $createTransferCommandHandler = $container->get(CreateTransferCommandHandler::class);
        $createTransferCommandHandler->execute($transferCommand);
    }

    private function truncateEntities(array $entities)
    {
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $connection = $entityManager->getConnection();
        $connection->beginTransaction();
        $connection->setAutoCommit(false);

        foreach ($entities as $entity) {
            $query = sprintf(
                'TRUNCATE "%s" RESTART IDENTITY CASCADE',
                $entityManager->getClassMetadata($entity)->getTableName()
            );

            $connection->executeQuery($query);
        }

        $connection->commit();
    }
}