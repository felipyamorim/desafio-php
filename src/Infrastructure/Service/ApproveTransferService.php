<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Transfer;
use App\Domain\Repository\TransferRepositoryInterface;
use App\Domain\Service\ApproveTransferServiceInterface;
use App\Infrastructure\Message\ApprovedTransfer;
use Symfony\Component\Messenger\MessageBusInterface;

class ApproveTransferService implements ApproveTransferServiceInterface
{
    public function __construct(
        private TransferRepositoryInterface $transferRepository,
        private MessageBusInterface $bus
    ) {}

    public function handle(Transfer $transfer): void
    {
        $transfer->setStatus(Transfer::APPROVED);
        $transfer->getPayee()->addBalance($transfer->getValue());
        $this->transferRepository->save($transfer);

        $this->bus->dispatch(new ApprovedTransfer($transfer->getId()));
    }
}