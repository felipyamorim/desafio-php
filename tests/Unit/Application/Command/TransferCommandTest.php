<?php

namespace App\Tests\Unit\Application\Command;

use App\Application\Command\TransferCommand;
use App\Application\Command\UserCommand;
use PHPUnit\Framework\TestCase;

class TransferCommandTest extends TestCase
{
    public function testCommand(): void
    {
        $expectedRequest = [
            'payer' => 1,
            'payee' => 2,
            'value' => 150,
        ];

        $transferCommand = new TransferCommand($expectedRequest);

        self::assertEquals($expectedRequest['payer'], $transferCommand->getPayer());
        self::assertEquals($expectedRequest['payee'], $transferCommand->getPayee());
        self::assertEquals($expectedRequest['value'], $transferCommand->getValue());
    }
}