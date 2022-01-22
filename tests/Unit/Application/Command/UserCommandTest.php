<?php

namespace App\Tests\Unit\Application\Command;

use App\Application\Command\UserCommand;
use PHPUnit\Framework\TestCase;

class UserCommandTest extends TestCase
{
    public function testCommand(): void
    {
        $expectedRequest = [
            'name' => 'João Alves',
            'document' => '44872223039',
            'email' => 'jalves@bestemail.com',
        ];

        $userCommand = new UserCommand($expectedRequest);

        self::assertEquals($expectedRequest['name'], $userCommand->getName());
        self::assertEquals($expectedRequest['document'], $userCommand->getDocument());
        self::assertEquals($expectedRequest['email'], $userCommand->getEmail());
    }
}