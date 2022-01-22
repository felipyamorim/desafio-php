<?php

declare(strict_types=1);

namespace App\Infrastructure\MessageHandler;

use App\Domain\Repository\TransferRepositoryInterface;
use App\Infrastructure\Message\ApprovedTransfer;
use App\Infrastructure\Message\TransferNotification;
use App\Infrastructure\Service\CreateNotificationService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ApprovedTransferHandler implements MessageHandlerInterface
{
    public function __construct(
        private TransferRepositoryInterface $transferRepository,
        private CreateNotificationService $createNotificationService,
        private MessageBusInterface $bus
    ) {}

    public function __invoke(ApprovedTransfer $message): void
    {
        $transfer = $this->transferRepository->get($message->getTransferId());

        $notification = $this->createNotificationService->handle($transfer);
        $this->bus->dispatch(new TransferNotification($notification->getId()));
    }
}