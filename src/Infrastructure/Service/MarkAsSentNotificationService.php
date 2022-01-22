<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Notification;
use App\Domain\Service\MarkAsSentNotificationServiceInterface;
use App\Infrastructure\Repository\NotificationRepository;

class MarkAsSentNotificationService implements MarkAsSentNotificationServiceInterface
{
    public function __construct(
        private NotificationRepository $notificationRepository,
    ) {}

    public function handle(Notification $notification): void
    {
        $notification->setStatus(Notification::SENT);
        $this->notificationRepository->save($notification);
    }
}