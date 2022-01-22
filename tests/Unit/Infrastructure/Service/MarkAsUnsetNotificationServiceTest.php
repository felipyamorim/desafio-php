<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\Notification;
use App\Infrastructure\Repository\NotificationRepository;
use App\Infrastructure\Service\MarkAsUnsetNotificationService;
use PHPUnit\Framework\TestCase;

class MarkAsUnsetNotificationServiceTest extends TestCase
{
    public function testMarkAsUnset(){
        $notificationRepository = $this->createMock(NotificationRepository::class);
        $notificationRepository->expects($this->once())->method('save');

        $notification = new Notification();

        $notificationService = new MarkAsUnsetNotificationService($notificationRepository);
        $notificationService->handle($notification);

        self::assertEquals(Notification::FAILED, $notification->getStatus());
    }
}
