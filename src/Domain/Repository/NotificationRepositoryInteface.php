<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Notification;

interface NotificationRepositoryInteface
{
    public function list(): array;
    public function get(int $id): ?Notification;
    public function save(Notification $transfer): void;
}