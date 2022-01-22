<?php

namespace App\Tests\Unit\Infrastructure\MessageHandler;

use App\Domain\Entity\Notification;
use App\Domain\Service\MarkAsSentNotificationServiceInterface;
use App\Domain\Service\MarkAsUnsentNotificationServiceInterface;
use App\Infrastructure\Message\TransferNotification;
use App\Infrastructure\MessageHandler\TransferNotificationHandler;
use App\Infrastructure\Repository\NotificationRepository;
use App\Infrastructure\Service\SendNotificationService;
use PHPUnit\Framework\TestCase;

class TransferNotificationHandlerTest extends TestCase
{
    public function testTransferNotificationHandlerSent()
    {
        $notificationRepository = $this->createMock(NotificationRepository::class);
        $notificationRepository->expects($this->once())->method('get')->willReturn(new Notification());

        $markAsSentNotificationServiceInterface = $this->createMock(MarkAsSentNotificationServiceInterface::class);
        $markAsSentNotificationServiceInterface->expects($this->once())->method('handle');

        $markAsUnsentNotificationServiceInterface = $this->createMock(MarkAsUnsentNotificationServiceInterface::class);

        $sendNotification = $this->createMock(SendNotificationService::class);
        $sendNotification->expects($this->once())->method('handle')->willReturn(true);

        $message = new TransferNotification(1);

        $transferNotificationHandler = new TransferNotificationHandler($notificationRepository, $markAsSentNotificationServiceInterface, $markAsUnsentNotificationServiceInterface, $sendNotification);
        $transferNotificationHandler($message);
    }

    public function testTransferNotificationHandlerUnsent()
    {
        $notificationRepository = $this->createMock(NotificationRepository::class);
        $notificationRepository->expects($this->once())->method('get')->willReturn(new Notification());

        $markAsSentNotificationServiceInterface = $this->createMock(MarkAsSentNotificationServiceInterface::class);

        $markAsUnsentNotificationServiceInterface = $this->createMock(MarkAsUnsentNotificationServiceInterface::class);
        $markAsUnsentNotificationServiceInterface->expects($this->once())->method('handle');

        $sendNotification = $this->createMock(SendNotificationService::class);
        $sendNotification->expects($this->once())->method('handle')->willReturn(false);

        $message = new TransferNotification(1);

        $transferNotificationHandler = new TransferNotificationHandler($notificationRepository, $markAsSentNotificationServiceInterface, $markAsUnsentNotificationServiceInterface, $sendNotification);
        $transferNotificationHandler($message);
    }
}