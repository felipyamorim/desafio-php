<?php

declare(strict_types=1);

namespace App\Infrastructure\MessageHandler;

use App\Domain\Repository\TransferRepositoryInterface;
use App\Domain\Service\ApproveTransferServiceInterface;
use App\Domain\Service\DenyTransferServiceInterface;
use App\Domain\Service\TransferAuthorizationServiceInterface;
use App\Infrastructure\Message\CreatedTransfer;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreatedTransferHandler implements MessageHandlerInterface
{
    public function __construct(
        private TransferRepositoryInterface $transferRepository,
        private TransferAuthorizationServiceInterface $transferAuthorizationService,
        private ApproveTransferServiceInterface $approveTransferService,
        private DenyTransferServiceInterface $denyTransferService,
    ) {}

    public function __invoke(CreatedTransfer $message): void
    {
        $transfer = $this->transferRepository->get($message->getTransferId());

        if(!$this->transferAuthorizationService->validate($transfer)){
            $this->denyTransferService->handle($transfer);
            return;
        }

        $this->approveTransferService->handle($transfer);
    }
}