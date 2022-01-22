<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Application\Command\UserCommand;
use App\Domain\Entity\User;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;

class UserFactory
{
    public static function createFromCommand(UserCommand $userCommand): User
    {
        $user = new User();

        $user
            ->setName($userCommand->getName())
            ->setEmail(new Email($userCommand->getEmail()))
            ->setDocument(new Document($userCommand->getDocument()))
            ->setType(strlen($userCommand->getDocument()) === 11 ? User::TYPE_COMMON : User::TYPE_SHOPKEEPER);

        return $user;
    }
}