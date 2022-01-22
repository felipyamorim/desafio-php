<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Transfer;

interface CreateTransferServiceInterface
{
    public function handle(Transfer $transfer): Transfer;
}