<?php

namespace App\Tests\Unit\Application\Factory;

use App\Application\Command\TransferCommand;
use App\Application\Factory\TransferFactory;
use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Domain\Exception\MissingPayeeTransferException;
use App\Domain\Exception\MissingPayerTransferException;
use App\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class TransferFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $transferCommand = new TransferCommand([
            'payer' => 1,
            'payee' => 2,
            'value' => 150,
        ]);

        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('get')->willReturn(new User());

        $transferFactory = new TransferFactory($userRepository);
        $transfer = $transferFactory->createFromCommand($transferCommand);

        self::assertInstanceOf(Transfer::class, $transfer);
    }

    public function testMissingPayerTransferferExceptionCreate(): void
    {
        self::expectException(MissingPayerTransferException::class);

        $transferCommand = new TransferCommand([
            'payee' => 2,
            'value' => 150,
        ]);

        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('get')->willReturn(new User());

        $transferFactory = new TransferFactory($userRepository);
        $transferFactory->createFromCommand($transferCommand);
    }

    public function testMissingPayeeTransferExceptionCreate(): void
    {
        self::expectException(MissingPayeeTransferException::class);

        $transferCommand = new TransferCommand([
            'payer' => 1,
            'value' => 150,
        ]);

        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('get')->willReturn(new User());

        $transferFactory = new TransferFactory($userRepository);
        $transferFactory->createFromCommand($transferCommand);
    }
}