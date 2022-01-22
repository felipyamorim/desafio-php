<?php

namespace App\Tests\Unit\Application\Factory;

use App\Application\Command\UserCommand;
use App\Application\Factory\UserFactory;
use App\Domain\Entity\User;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $userCommand = new UserCommand([
            'name' => 'João Alves',
            'document' => '448.722.230-39',
            'email' => 'jalves@bestemail.com',
        ]);

        $user = UserFactory::createFromCommand($userCommand);

        self::assertInstanceOf(User::class, $user);
    }
}