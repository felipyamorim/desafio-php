<?php

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\TransferCommand;
use App\Application\CommandHandler\CreateTransferCommandHandler;
use App\Application\Factory\TransferFactory;
use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Service\CreateTransferService;
use PHPUnit\Framework\TestCase;

class CreateTransferCommandHandlerTest extends TestCase
{
    public function testCreateCommand(): void
    {
        $request = [
            'payer' => 1,
            'payee' => 2,
            'value' => 150,
        ];

        $createTransferService = $this->createMock(CreateTransferService::class);
        $createTransferService->method('handle')->willReturn(new Transfer());

        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('get')->willReturn(new User());

        $createTransferCommandHandler = new CreateTransferCommandHandler($createTransferService, new TransferFactory($userRepository));
        $transfer = $createTransferCommandHandler->execute(new TransferCommand($request));

        self::assertInstanceOf(Transfer::class, $transfer);
        self::assertInstanceOf(User::class, $transfer->getPayer());
        self::assertInstanceOf(User::class, $transfer->getPayee());
        self::assertEquals($request['value'], $transfer->getValue());
    }

    public function testThrowExceptionCreateCommand(): void
    {
        self::expectException(\Exception::class);

        $request = [
            'payer' => 1,
            'payee' => 2,
            'value' => 150,
        ];

        $createTransferService = $this->createMock(CreateTransferService::class);
        $createTransferService->method('handle')->willThrowException(new \Exception());

        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('get')->willReturn(new User());

        $createTransferCommandHandler = new CreateTransferCommandHandler($createTransferService, new TransferFactory($userRepository));
        $createTransferCommandHandler->execute(new TransferCommand($request));
    }
}