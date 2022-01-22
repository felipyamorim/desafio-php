<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class TransferTest extends TestCase
{
    public function testEntity(){

        $payer = new User();
        $payee = new User();
        $value = 1500;

        $transfer = new Transfer();
        $transfer
            ->setPayer($payer)
            ->setPayee($payee)
            ->setValue($value)
            ->setStatus(Transfer::PENDING)
        ;

        self::assertNull($transfer->getId());
        self::assertNull($transfer->getCreatedAt());
        self::assertNull($transfer->getUpdatedAt());

        $transfer->updatedTimestamps();

        self::assertEquals($payer, $transfer->getPayer());
        self::assertEquals($payee, $transfer->getPayee());
        self::assertEquals($value, $transfer->getValue());
        self::assertEquals(Transfer::PENDING, $transfer->getStatus());
        self::assertEquals('pending', $transfer->getStatus());
        self::assertInstanceOf(\DateTimeInterface::class, $transfer->getCreatedAt());
        self::assertInstanceOf(\DateTimeInterface::class, $transfer->getUpdatedAt());
        self::assertIsArray($transfer->jsonSerialize());
    }
}