<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Transfer;
use App\Domain\Exception\InsufficientFundsException;
use App\Domain\Exception\InvalidPayerTypeException;
use App\Domain\Exception\InvalidValueTransferException;
use App\Domain\Exception\TransferSameUserException;
use App\Domain\Repository\TransferRepositoryInterface;
use App\Domain\Service\CreateTransferServiceInterface;
use App\Infrastructure\Message\CreatedTransfer;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateTransferService implements CreateTransferServiceInterface
{
    public function __construct(
        private TransferRepositoryInterface $transferRepository,
        private MessageBusInterface $bus
    ) {}

    public function handle(Transfer $transfer): Transfer
    {
        if($transfer->getPayer()->isShopkeeper()){
            throw new InvalidPayerTypeException();
        }

        if(!$transfer->getValue() > 0){
            throw new InvalidValueTransferException();
        }

        if($transfer->getPayer()->getBalance() < $transfer->getValue()){
            throw new InsufficientFundsException();
        }

        if($transfer->getPayer() === $transfer->getPayee()){
            throw new TransferSameUserException();
        }

        $transfer->getPayer()->removeBalance($transfer->getValue());
        $this->transferRepository->save($transfer);

        $this->bus->dispatch(new CreatedTransfer($transfer->getId()));

        return $transfer;
    }
}