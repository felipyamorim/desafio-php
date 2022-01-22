<?php

declare(strict_types=1);

namespace App\Infrastructure\Message;

class ApprovedTransfer
{
    public function __construct(
        private int $transferId
    ) {}

    public function getTransferId(): int
    {
        return $this->transferId;
    }
}