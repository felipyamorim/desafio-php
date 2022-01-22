<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Notification;

interface MarkAsUnsentNotificationServiceInterface
{
    public function handle(Notification $notification): void;
}