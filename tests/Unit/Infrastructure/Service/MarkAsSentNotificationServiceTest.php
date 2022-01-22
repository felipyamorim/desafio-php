<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\Notification;
use App\Infrastructure\Repository\NotificationRepository;
use App\Infrastructure\Service\MarkAsSentNotificationService;
use PHPUnit\Framework\TestCase;

class MarkAsSentNotificationServiceTest extends TestCase
{
    public function testMarkAsSent(){
        $notificationRepository = $this->createMock(NotificationRepository::class);
        $notificationRepository->expects($this->once())->method('save');

        $notification = new Notification();

        $markAsSentNotificationService = new MarkAsSentNotificationService($notificationRepository);
        $markAsSentNotificationService->handle($notification);

        self::assertEquals(Notification::SENT, $notification->getStatus());
    }
}
