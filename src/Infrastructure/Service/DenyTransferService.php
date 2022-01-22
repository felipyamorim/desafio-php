<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Transfer;
use App\Domain\Repository\TransferRepositoryInterface;
use App\Domain\Service\DenyTransferServiceInterface;

class DenyTransferService implements DenyTransferServiceInterface
{
    public function __construct(
        private TransferRepositoryInterface $transferRepository
    ) {}

    public function handle(Transfer $transfer): void
    {
        $transfer->setStatus(Transfer::DENIED);
        $transfer->getPayer()->addBalance($transfer->getValue());

        $this->transferRepository->save($transfer);
    }
}