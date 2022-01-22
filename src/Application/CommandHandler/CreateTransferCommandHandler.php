<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\TransferCommand;
use App\Application\Factory\TransferFactory;
use App\Domain\Entity\Transfer;
use App\Infrastructure\Service\CreateTransferService;

class CreateTransferCommandHandler
{
    public function __construct(
        private CreateTransferService $service,
        private TransferFactory $transferFactory
    ) {}

    public function execute(TransferCommand $command): Transfer
    {
        $transfer = $this->transferFactory->createFromCommand($command);

        $this->service->handle($transfer);

        return $transfer;
    }
}