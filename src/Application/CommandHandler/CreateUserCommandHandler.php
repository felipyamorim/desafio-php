<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\UserCommand;
use App\Application\Factory\UserFactory;
use App\Domain\Entity\User;
use App\Infrastructure\Service\CreateUserService;

class CreateUserCommandHandler
{
    public function __construct(
        private CreateUserService $service
    ) { }

    public function execute(UserCommand $command): User
    {
        $user = UserFactory::createFromCommand($command);

        $this->service->handle($user);

        return $user;
    }
}