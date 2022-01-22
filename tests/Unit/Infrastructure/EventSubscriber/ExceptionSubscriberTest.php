<?php

namespace App\Tests\Unit\Infrastructure\EventSubscriber;

use App\Domain\Exception\InvalidPayerTypeException;
use App\Infrastructure\EventSubscriber\ExceptionSubscriber;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriberTest extends KernelTestCase
{
    public function testHandleExceptionJsonResponse()
    {
        self::assertIsArray(ExceptionSubscriber::getSubscribedEvents());

        $dispatcher = new EventDispatcher();

        $subscriber = new ExceptionSubscriber();
        $dispatcher->addListener(KernelEvents::EXCEPTION, [$subscriber, 'handleException']);

        $event = $this->createExceptionEvent(new \Exception());

        $dispatcher->dispatch($event, KernelEvents::EXCEPTION);

        self::assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testHandleUnprocessableEntityExceptionJsonResponse()
    {
        self::assertIsArray(ExceptionSubscriber::getSubscribedEvents());

        $dispatcher = new EventDispatcher();

        $subscriber = new ExceptionSubscriber();
        $dispatcher->addListener(KernelEvents::EXCEPTION, [$subscriber, 'handleUnprocessableEntityException']);

        $event = $this->createExceptionEvent(new InvalidPayerTypeException());
        $dispatcher->dispatch($event, KernelEvents::EXCEPTION);

        self::assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testWrongHandleUnprocessableEntityExceptionJsonResponse()
    {
        self::assertIsArray(ExceptionSubscriber::getSubscribedEvents());

        $dispatcher = new EventDispatcher();

        $subscriber = new ExceptionSubscriber();
        $dispatcher->addListener(KernelEvents::EXCEPTION, [$subscriber, 'handleUnprocessableEntityException']);

        $event = $this->createExceptionEvent(new \Exception());
        $dispatcher->dispatch($event, KernelEvents::EXCEPTION);

        self::assertNull($event->getResponse());
    }

    private function createExceptionEvent(\Throwable $exception): ExceptionEvent
    {
        $kernel = $this->getMockBuilder(HttpKernelInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestType = HttpKernelInterface::MAIN_REQUEST;

        return new ExceptionEvent(
            $kernel,
            $request,
            $requestType,
            $exception
        );
    }
}