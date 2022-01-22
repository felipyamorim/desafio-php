<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testValue()
    {
        $expectedValue = 'jalves@bestemail.com';
        $email = new Email($expectedValue);

        self::assertEquals($expectedValue, (string) $email);
    }

    public function testInvalidException()
    {
        self::expectException(\Exception::class);
        new Email('invalid');
    }
}