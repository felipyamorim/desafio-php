<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Repository\UserRepository;
use App\Infrastructure\Service\CreateUserService;
use PHPUnit\Framework\TestCase;

class CreateUserServiceTest extends TestCase
{
    public function testCreate()
    {
        $userCreate = new User();
        $userCreate
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
        ;

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())->method('findByEmail')->willReturn(null);
        $userRepository->expects($this->once())->method('findByDocument')->willReturn(null);
        $userRepository->expects($this->once())->method('save');

        $createUserService = new CreateUserService($userRepository);
        $user = $createUserService->handle($userCreate);

        self::assertInstanceOf(User::class, $user);
    }

    public function testExceptionEmailCreate()
    {
        self::expectException(\Exception::class);

        $userCreate = new User();
        $userCreate
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
        ;

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())->method('findByEmail')->willReturn(new User());

        $createUserService = new CreateUserService($userRepository);
        $createUserService->handle($userCreate);
    }

    public function testExceptionDocumentCreate()
    {
        self::expectException(\Exception::class);

        $userCreate = new User();
        $userCreate
            ->setName('João Alves')
            ->setDocument(New Document('448.722.230-39'))
            ->setEmail(new Email('jalves@bestemail.com'))
        ;

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())->method('findByDocument')->willReturn(new User());

        $createUserService = new CreateUserService($userRepository);
        $createUserService->handle($userCreate);
    }
}
