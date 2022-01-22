<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\User;

interface CreateUserServiceInterface
{
    public function handle(User $user): User;
}