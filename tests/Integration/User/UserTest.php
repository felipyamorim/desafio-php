<?php

namespace App\Tests\Integration\User;

use App\Application\Command\UserCommand;
use App\Application\CommandHandler\CreateUserCommandHandler;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
    }

    public function testCommonUserCreate()
    {
        self::bootKernel();

        $userCommand = new UserCommand([
            'name' => 'Marcio Souza',
            'document' => '754.656.380-10',
            'email' => 'msouza@bestemail.com',
        ]);

        $container = static::getContainer();

        /** @var CreateUserCommandHandler $createUserCommandHandler */
        $createUserCommandHandler = $container->get(CreateUserCommandHandler::class);
        $user = $createUserCommandHandler->execute($userCommand);

        $userRepository = $container->get(UserRepositoryInterface::class);

        self::assertCount(1, $userRepository->list());
        self::assertEquals(User::TYPE_COMMON, $user->getType());
    }

    public function testShopkeeperUserCreate()
    {
        self::bootKernel();

        $userCommand = new UserCommand([
            'name' => 'Supermercado Preço Baixo',
            'document' => '16.411.801/0001-80',
            'email' => 'contato@superprecobaixo.com',
        ]);

        $container = static::getContainer();

        /** @var CreateUserCommandHandler $createUserCommandHandler */
        $createUserCommandHandler = $container->get(CreateUserCommandHandler::class);
        $user = $createUserCommandHandler->execute($userCommand);

        $userRepository = $container->get(UserRepositoryInterface::class);

        self::assertCount(1, $userRepository->list());
        self::assertEquals(User::TYPE_SHOPKEEPER, $user->getType());
    }
}