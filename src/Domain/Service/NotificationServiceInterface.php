<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Notification;
use App\Domain\Entity\Transfer;

interface NotificationServiceInterface
{
    public function createTransferNotification(Transfer $transfer): Notification;
    public function markAsSent(Notification $user): void;
    public function markAsFailed(Notification $user): void;
    public function send(Notification $user): void;
}