<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Notification;
use App\Domain\Service\MarkAsUnsentNotificationServiceInterface;
use App\Infrastructure\Repository\NotificationRepository;

class MarkAsUnsetNotificationService implements MarkAsUnsentNotificationServiceInterface
{
    public function __construct(
        private NotificationRepository $notificationRepository,
    ) {}

    public function handle(Notification $notification): void
    {
        $notification->setStatus(Notification::FAILED);
        $this->notificationRepository->save($notification);
    }
}