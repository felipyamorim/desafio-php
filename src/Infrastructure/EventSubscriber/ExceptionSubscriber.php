<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['handleUnprocessableEntityException', 10],
                ['handleException', 0]
            ]
        ];
    }

    public function handleUnprocessableEntityException(ExceptionEvent $event)
    {
        if($event->getThrowable()->getCode() !== Response::HTTP_UNPROCESSABLE_ENTITY){
            return null;
        }

        $event->setResponse(new JsonResponse([
            'type' => 'error',
            'errors' => [
                $event->getThrowable()->getMessage()
            ]
        ]));
    }

    public function handleException(ExceptionEvent $event)
    {
        $event->setResponse(new JsonResponse([
            'type' => 'error',
            'message' => $event->getThrowable()->getMessage()
        ]));
    }
}