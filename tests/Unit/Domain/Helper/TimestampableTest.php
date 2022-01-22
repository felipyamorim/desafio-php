<?php

namespace App\Tests\Unit\Domain\Helper;

use App\Domain\Helper\TimestampableTrait;
use PHPUnit\Framework\TestCase;

class TimestampableTest extends TestCase
{
    public function testTimestamps()
    {
        $class = new class {
            use TimestampableTrait;
        };

        self::assertNull($class->getCreatedAt());
        self::assertNull($class->getUpdatedAt());

        $class->updatedTimestamps();

        self::assertInstanceOf(\DateTimeInterface::class, $class->getCreatedAt());
        self::assertInstanceOf(\DateTimeInterface::class, $class->getUpdatedAt());
    }
}