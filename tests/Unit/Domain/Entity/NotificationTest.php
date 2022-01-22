<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\Notification;
use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    public function testEntity(){

        $transfer = new Transfer();
        $receiver = new User();

        $notification = new Notification();
        $notification
            ->setTransfer($transfer)
            ->setReceiver($receiver)
            ->setStatus(Notification::PENDING)
        ;

        self::assertNull($notification->getId());
        self::assertNull($notification->getCreatedAt());
        self::assertNull($notification->getUpdatedAt());

        $notification->updatedTimestamps();

        self::assertEquals($transfer, $notification->getTransfer());
        self::assertEquals($receiver, $notification->getReceiver());
        self::assertEquals(Notification::PENDING, $notification->getStatus());
        self::assertInstanceOf(\DateTimeInterface::class, $notification->getCreatedAt());
        self::assertInstanceOf(\DateTimeInterface::class, $notification->getUpdatedAt());
        self::assertIsArray($notification->jsonSerialize());
    }
}