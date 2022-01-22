<?php

namespace App\Tests\Unit\Infrastructure\MessageHandler;

use App\Domain\Entity\Notification;
use App\Domain\Entity\Transfer;
use App\Domain\Repository\TransferRepositoryInterface;
use App\Infrastructure\Message\ApprovedTransfer;
use App\Infrastructure\MessageHandler\ApprovedTransferHandler;
use App\Infrastructure\Service\CreateNotificationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBus;

class ApprovedTransferHandlerTest extends TestCase
{
    public function testApprovadeTransferHandler()
    {
        $notification = new Notification();

        $reflectionClass = new \ReflectionClass($notification);
        $idProperty = $reflectionClass->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($notification, 1);

        $transferRepository = $this->createMock(TransferRepositoryInterface::class);
        $transferRepository->expects($this->once())->method('get')->willReturn(new Transfer());

        $createNotificationService = $this->createMock(CreateNotificationService::class);
        $createNotificationService->expects($this->once())->method('handle')->willReturn($notification);

        $message = new ApprovedTransfer($notification->getId());

        $approvedTransferNotificationHandler = new ApprovedTransferHandler($transferRepository, $createNotificationService, new MessageBus());
        $approvedTransferNotificationHandler($message);
    }
}