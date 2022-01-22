<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Transfer;

interface DenyTransferServiceInterface
{
    public function handle(Transfer $transfer): void;
}