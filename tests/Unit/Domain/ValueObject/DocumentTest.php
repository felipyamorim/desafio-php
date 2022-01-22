<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Document;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testCpfValue()
    {
        $expectedValue = '44872223039';
        $document = new Document($expectedValue);

        self::assertEquals($expectedValue, (string) $document);
    }

    public function testCnpjalue()
    {
        $expectedValue = '35656310000143';
        $document = new Document($expectedValue);

        self::assertEquals($expectedValue, (string) $document);
    }

    public function testInvalidException()
    {
        self::expectException(\Exception::class);
        new Document('invalid');
    }
}