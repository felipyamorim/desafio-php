<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\User;
use App\Domain\Exception\DocumentAlreadyUsedException;
use App\Domain\Exception\EmailAlreadyUsedException;
use App\Domain\Service\CreateUserServiceInterface;
use App\Infrastructure\Repository\UserRepository;

class CreateUserService implements CreateUserServiceInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function handle(User $user): User
    {
        if($this->userRepository->findByEmail($user->getEmail())){
            throw new EmailAlreadyUsedException($user->getEmail());
        }

        if($this->userRepository->findByDocument($user->getDocument())){
            throw new DocumentAlreadyUsedException($user->getDocument());
        }

        $this->userRepository->save($user);

        return $user;
    }
}