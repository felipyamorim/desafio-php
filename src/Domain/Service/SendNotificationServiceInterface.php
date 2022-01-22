<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Notification;

interface SendNotificationServiceInterface
{
    public function handle(Notification $notification): bool;
}