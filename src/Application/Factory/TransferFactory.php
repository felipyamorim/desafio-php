<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Application\Command\TransferCommand;
use App\Domain\Entity\Transfer;
use App\Domain\Exception\MissingPayeeTransferException;
use App\Domain\Exception\MissingPayerTransferException;
use App\Domain\Repository\UserRepositoryInterface;

class TransferFactory
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function createFromCommand(TransferCommand $transferCommand): Transfer
    {
        if(!$transferCommand->getPayer()){
            throw new MissingPayerTransferException();
        }

        if(!$transferCommand->getPayee()){
            throw new MissingPayeeTransferException();
        }

        $transfer = new Transfer();

        $transfer
            ->setPayer($this->userRepository->get($transferCommand->getPayer()))
            ->setPayee($this->userRepository->get($transferCommand->getPayee()))
            ->setValue((string) $transferCommand->getValue())
        ;

        return $transfer;
    }
}