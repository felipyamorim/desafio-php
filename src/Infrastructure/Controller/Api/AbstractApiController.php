<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractApiController extends AbstractController
{
    public function __construct(
        protected ValidatorInterface $validator
    ) { }

    protected function responseOk(array|object $data = []): JsonResponse
    {
        return $this->json([
            'type' => 'success',
            'data' => $data
        ], Response::HTTP_OK);
    }

    protected function responseCreated(array|object $data = []): JsonResponse
    {
        return $this->json([
            'type' => 'success',
            'data' => $data
        ], Response::HTTP_CREATED);
    }

    protected function responseValidationFailed(array $errors = []): JsonResponse
    {
        return $this->json([
            'type' => 'error',
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function responseNotFound(string $message): JsonResponse
    {
        return $this->json([
            'type' => 'error',
            'message' => $message
        ], Response::HTTP_NOT_FOUND);
    }

    protected function violationsToArray(ConstraintViolationListInterface $constraintViolationList){
        $errors = [];
        foreach ($constraintViolationList as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}