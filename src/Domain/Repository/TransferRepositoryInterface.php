<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Transfer;

interface TransferRepositoryInterface
{
    public function list(): array;
    public function get(int $id): ?Transfer;
    public function save(Transfer $transfer): void;
}