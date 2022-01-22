<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Notification;
use App\Domain\Entity\Transfer;
use App\Domain\Service\CreateNotificationServiceInterface;
use App\Infrastructure\Repository\NotificationRepository;

class CreateNotificationService implements CreateNotificationServiceInterface
{
    public function __construct(
        private NotificationRepository $notificationRepository
    ) {}

    public function handle(Transfer $transfer): Notification
    {
        $notification = new Notification();
        $notification
            ->setTransfer($transfer)
            ->setReceiver($transfer->getPayee());

        $this->notificationRepository->save($notification);

        return $notification;
    }
}