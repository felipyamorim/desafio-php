<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api;

use App\Application\Command\UserCommand;
use App\Application\CommandHandler\CreateUserCommandHandler;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractApiController
{
    #[Route('/user', name: 'user', methods: 'GET')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->responseOk($users);
    }

    #[Route('/user', name: 'user_new', methods: 'POST')]
    public function new(Request $request, CreateUserCommandHandler $commandHandler): Response
    {
        $userCommand = new UserCommand($request->toArray());

        $violations = $this->validator->validate($userCommand);
        if (count($violations) > 0) {
            $violationList = $this->violationsToArray($violations);
            return $this->responseValidationFailed($violationList);
        }

        $user = $commandHandler->execute($userCommand);

        return $this->responseCreated($user);
    }

    #[Route('/user/{id}', name: 'user_show', methods: 'GET')]
    public function show($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if( ! $user){
            throw new NotFoundHttpException('The user does not exist.');
        }

        return $this->responseOk($user);
    }
}
