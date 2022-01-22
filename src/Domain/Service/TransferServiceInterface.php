<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Transfer;

interface TransferServiceInterface
{
    public function register(Transfer $transfer): Transfer;
    public function approve(Transfer $transfer): void;
    public function deny(Transfer $transfer): void;
}