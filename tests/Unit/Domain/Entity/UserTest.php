<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testEntity(){
        $data = [
            'name' => 'João Alves',
            'document' => '44872223039',
            'email' => 'jalves@bestemail.com',
            'balance' => 1500
        ];

        $user = new User();
        $user
            ->setName($data['name'])
            ->setDocument(New Document($data['document']))
            ->setEmail(new Email($data['email']))
        ;

        self::assertNull($user->getId());
        self::assertNull($user->getCreatedAt());
        self::assertNull($user->getUpdatedAt());
        self::assertEquals($data['name'], $user->getName());
        self::assertEquals($data['document'], $user->getDocument());
        self::assertEquals($data['email'], $user->getEmail());

        $user->addBalance($data['balance']);
        self::assertEquals($data['balance'], $user->getBalance());

        $user->removeBalance($data['balance']);
        self::assertEquals(0, $user->getBalance());

        $user->setType(User::TYPE_COMMON);
        self::assertEquals(User::TYPE_COMMON, $user->getType());
        self::assertTrue($user->isCommon());

        $user->setType(User::TYPE_SHOPKEEPER);
        self::assertEquals(User::TYPE_SHOPKEEPER, $user->getType());
        self::assertTrue($user->isShopkeeper());

        $user->updatedTimestamps();
        self::assertInstanceOf(\DateTimeInterface::class, $user->getCreatedAt());
        self::assertInstanceOf(\DateTimeInterface::class, $user->getUpdatedAt());
        self::assertIsArray($user->jsonSerialize());
    }
}