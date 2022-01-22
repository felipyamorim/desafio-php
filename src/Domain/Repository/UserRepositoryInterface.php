<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function list(): array;
    public function get(int $id): ?User;
    public function findByDocument(string $document): ?User;
    public function findByEmail(string $email): ?User;
    public function save(User $user): void;
}