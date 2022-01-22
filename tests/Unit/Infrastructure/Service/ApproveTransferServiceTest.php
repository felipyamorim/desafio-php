<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Domain\Repository\TransferRepositoryInterface;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Message\ApprovedTransfer;
use App\Infrastructure\Service\ApproveTransferService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class ApproveTransferServiceTest extends TestCase
{
    public function testApproveTransfer()
    {
        $balance = 1000;

        $payee = new User();
        $payee
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
            ->setType(User::TYPE_COMMON)
            ->addBalance($balance)
        ;

        $transferId = 1;
        $transfer = new Transfer();
        $transfer
            ->setPayer(new User())
            ->setPayee($payee)
            ->setValue(150)
        ;

        $reflectionClass = new \ReflectionClass($transfer);
        $idProperty = $reflectionClass->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($transfer, $transferId);

        $transferRepository = $this->createMock(TransferRepositoryInterface::class);
        $transferRepository->expects($this->once())->method('save');

        $message = new ApprovedTransfer($transfer->getId());
        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus->expects($this->once())->method('dispatch')->with($message)->willReturn(new Envelope($message));

        $approveTransferService = new ApproveTransferService($transferRepository, $messageBus);
        $approveTransferService->handle($transfer);

        self::assertEquals($payee->getBalance(), $balance + $transfer->getValue());
        self::assertEquals($transferId, $message->getTransferId());
    }
}
