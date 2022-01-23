<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api;

use App\Application\Command\TransferCommand;
use App\Application\CommandHandler\CreateTransferCommandHandler;
use App\Infrastructure\Repository\TransferRepository;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class TransferController extends AbstractApiController
{
    #[Route('/transfer', name: 'transfer', methods: 'GET')]
    public function index(TransferRepository $transferRepository): Response
    {
        $transfers = $transferRepository->findAll();
        return $this->responseOk($transfers);
    }

    #[Route('/transfer', name: 'transfer_new', methods: 'POST')]
    public function new(Request $request, CreateTransferCommandHandler $commandHandler): Response
    {
        $transferCommand = new TransferCommand($request->toArray());

        $violations = $this->validator->validate($transferCommand);
        if (count($violations) > 0) {
            $violationList = $this->violationsToArray($violations);
            return $this->responseValidationFailed($violationList);
        }

        $transfer = $commandHandler->execute($transferCommand);

        return $this->responseCreated($transfer);
    }

    #[Route('/transfer/{id}', name: 'transfer_show', methods: 'GET')]
    public function show($id, UserRepository $transferRepository): Response
    {
        $transfer = $transferRepository->find($id);

        if (!$transfer) {
            throw new NotFoundHttpException('The transfer does not exist.');
        }

        return $this->responseOk($transfer);
    }
}
