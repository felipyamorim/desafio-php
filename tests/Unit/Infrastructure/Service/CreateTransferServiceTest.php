<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Domain\Exception\InsufficientFundsException;
use App\Domain\Exception\InvalidPayerTypeException;
use App\Domain\Exception\InvalidValueTransferException;
use App\Domain\Exception\TransferSameUserException;
use App\Domain\Repository\TransferRepositoryInterface;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Message\CreatedTransfer;
use App\Infrastructure\Service\CreateTransferService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateTransferServiceTest extends TestCase
{
    public function testRegister()
    {
        $payer = new User();
        $payer
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
            ->setType(User::TYPE_COMMON)
            ->addBalance(1000)
        ;

        $transferId = 1;
        $transfer = new Transfer();
        $transfer
            ->setPayer($payer)
            ->setPayee(new User())
            ->setValue(150)
        ;

        $reflectionClass = new \ReflectionClass($transfer);
        $idProperty = $reflectionClass->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($transfer, $transferId);

        $transferRepository = $this->createMock(TransferRepositoryInterface::class);
        $transferRepository->expects($this->once())->method('save');

        $message = new CreatedTransfer($transfer->getId());
        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus->expects($this->once())->method('dispatch')->with($message)->willReturn(new Envelope($message));

        $createTransferService = new CreateTransferService($transferRepository, $messageBus);
        $transfer = $createTransferService->handle($transfer);

        self::assertInstanceOf(Transfer::class, $transfer);
        self::assertEquals($transferId, $message->getTransferId());
    }

    public function testInvalidPayer()
    {
        self::expectException(InvalidPayerTypeException::class);

        $transferRepository = $this->createMock(TransferRepositoryInterface::class);

        $payer = new User();
        $payer
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
            ->setType(User::TYPE_SHOPKEEPER)
            ->addBalance(1000)
        ;

        $transfer = new Transfer();
        $transfer
            ->setPayer($payer)
            ->setPayee(new User())
            ->setValue(150)
        ;

        $messageBus = $this->createMock(MessageBusInterface::class);

        $createTransferService = new CreateTransferService($transferRepository, $messageBus);
        $createTransferService->handle($transfer);
    }

    public function testInvalidValueTransfer()
    {
        self::expectException(InvalidValueTransferException::class);

        $transferRepository = $this->createMock(TransferRepositoryInterface::class);

        $payer = new User();
        $payer
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
            ->setType(User::TYPE_COMMON)
            ->addBalance(1000)
        ;

        $transfer = new Transfer();
        $transfer
            ->setPayer($payer)
            ->setPayee(new User())
            ->setValue(0)
        ;

        $messageBus = $this->createMock(MessageBusInterface::class);

        $createTransferService = new CreateTransferService($transferRepository, $messageBus);
        $createTransferService->handle($transfer);
    }

    public function testInsufficientFunds()
    {
        self::expectException(InsufficientFundsException::class);

        $transferRepository = $this->createMock(TransferRepositoryInterface::class);

        $payer = new User();
        $payer
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
            ->setType(User::TYPE_COMMON)
            ->addBalance(1000)
        ;

        $transfer = new Transfer();
        $transfer
            ->setPayer($payer)
            ->setPayee(new User())
            ->setValue(1500)
        ;

        $messageBus = $this->createMock(MessageBusInterface::class);

        $createTransferService = new CreateTransferService($transferRepository, $messageBus);
        $createTransferService->handle($transfer);
    }

    public function testTransferSameUser()
    {
        self::expectException(TransferSameUserException::class);

        $transferRepository = $this->createMock(TransferRepositoryInterface::class);

        $payer = new User();
        $payer
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
            ->setType(User::TYPE_COMMON)
            ->addBalance(1000)
        ;

        $transfer = new Transfer();
        $transfer
            ->setPayer($payer)
            ->setPayee($payer)
            ->setValue(150)
        ;

        $messageBus = $this->createMock(MessageBusInterface::class);

        $createTransferService = new CreateTransferService($transferRepository, $messageBus);
        $createTransferService->handle($transfer);
    }
}
