<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Domain\Repository\TransferRepositoryInterface;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Service\DenyTransferService;
use PHPUnit\Framework\TestCase;

class DenyTransferServiceTest extends TestCase
{
    public function testDenyTransfer()
    {
        $balance = 1000;

        $payer = new User();
        $payer
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
            ->setType(User::TYPE_COMMON)
            ->addBalance($balance)
        ;

        $transfer = new Transfer();
        $transfer
            ->setPayer($payer)
            ->setPayee(new User())
            ->setValue(150)
        ;

        $transferRepository = $this->createMock(TransferRepositoryInterface::class);
        $transferRepository->expects($this->once())->method('save');

        $denyTransferService = new DenyTransferService($transferRepository);
        $denyTransferService->handle($transfer);

        self::assertEquals($payer->getBalance(), $balance + $transfer->getValue());
    }
}
