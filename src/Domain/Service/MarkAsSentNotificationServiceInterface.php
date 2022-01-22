<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Notification;

interface MarkAsSentNotificationServiceInterface
{
    public function handle(Notification $notification): void;
}