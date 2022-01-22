<?php

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\UserCommand;
use App\Application\CommandHandler\CreateUserCommandHandler;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\UserRepository;
use App\Infrastructure\Service\CreateUserService;
use PHPUnit\Framework\TestCase;

class CreateUserCommandHandlerTest extends TestCase
{
    public function testCommonCommand(): void
    {
        $request = [
            'name' => 'João Alves',
            'document' => '44872223039',
            'email' => 'jalves@bestemail.com',
        ];

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())->method('save');

        $createUserCommandHandler = new CreateUserCommandHandler(new CreateUserService($userRepository));
        $user = $createUserCommandHandler->execute(new UserCommand($request));

        self::assertInstanceOf(User::class, $user);
        self::assertEquals(User::TYPE_COMMON, $user->getType());
    }

    public function testShopkeeperCommand(): void
    {
        $request = [
            'name' => 'Best Hardware',
            'document' => '35656310000143',
            'email' => 'contact@besthardware.com',
        ];

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())->method('save');

        $createUserCommandHandler = new CreateUserCommandHandler(new CreateUserService($userRepository));
        $user = $createUserCommandHandler->execute(new UserCommand($request));

        self::assertInstanceOf(User::class, $user);
        self::assertEquals(User::TYPE_SHOPKEEPER, $user->getType());
    }

    public function testThrowExceptionCommand(): void
    {
        self::expectException(\Exception::class);

        $request = [
            'name' => 'Best Hardware',
            'document' => '35656310000143',
            'email' => 'contact@besthardware.com',
        ];

        $createUserService = $this->createMock(CreateUserService::class);
        $createUserService->method('handle')->willThrowException(new \Exception());

        $createUserCommandHandler = new CreateUserCommandHandler($createUserService);
        $createUserCommandHandler->execute(new UserCommand($request));
    }
}