<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Transfer;

interface TransferAuthorizationServiceInterface
{
    public function validate(Transfer $transfer): bool;
}