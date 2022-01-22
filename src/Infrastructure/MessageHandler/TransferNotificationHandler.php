<?php

declare(strict_types=1);

namespace App\Infrastructure\MessageHandler;

use App\Domain\Service\MarkAsSentNotificationServiceInterface;
use App\Domain\Service\MarkAsUnsentNotificationServiceInterface;
use App\Infrastructure\Message\TransferNotification;
use App\Infrastructure\Repository\NotificationRepository;
use App\Infrastructure\Service\SendNotificationService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TransferNotificationHandler implements MessageHandlerInterface
{
    public function __construct(
        private NotificationRepository $notificationRepository,
        private MarkAsSentNotificationServiceInterface $markAsSentNotificationService,
        private MarkAsUnsentNotificationServiceInterface $markAsUnsentNotificationService,
        private SendNotificationService $sendNotification
    ) {}

    public function __invoke(TransferNotification $message): void
    {
        $notification = $this->notificationRepository->get($message->getNotificationId());

        if (!$this->sendNotification->handle($notification)) {
            $this->markAsUnsentNotificationService->handle($notification);
            return;
        }

        $this->markAsSentNotificationService->handle($notification);
    }
}