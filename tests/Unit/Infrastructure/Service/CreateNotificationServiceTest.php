<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\Notification;
use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Repository\NotificationRepository;
use App\Infrastructure\Service\CreateNotificationService;
use PHPUnit\Framework\TestCase;

class CreateNotificationServiceTest extends TestCase
{
    public function testCreateNotification()
    {
        $payee = new User();
        $payee->setEmail(new Email('jalves@bestemail.com'));

        $transfer = new Transfer();
        $transfer->setPayee($payee);

        $notificationRepository = $this->createMock(NotificationRepository::class);
        $notificationRepository->expects($this->once())->method('save');

        $createNotificationService = new CreateNotificationService($notificationRepository);
        $notification = $createNotificationService->handle($transfer);

        self::assertInstanceOf(Notification::class, $notification);
        self::assertEquals($payee, $notification->getReceiver());
        self::assertEquals($transfer, $notification->getTransfer());
    }
}
