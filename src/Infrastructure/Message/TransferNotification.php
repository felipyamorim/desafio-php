<?php

declare(strict_types=1);

namespace App\Infrastructure\Message;

class TransferNotification
{
    public function __construct(
        private int $notificationId
    ) {}

    public function getNotificationId(): int
    {
        return $this->notificationId;
    }
}