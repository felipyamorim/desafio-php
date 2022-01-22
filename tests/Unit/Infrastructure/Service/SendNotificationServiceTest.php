<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\Notification;
use App\Infrastructure\Service\SendNotificationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SendNotificationServiceTest extends TestCase
{
    public function testSend(){

        $expectedResponseData = [
            'message' => 'Success'
        ];

        $httpClient = $this->mockHttpClient($expectedResponseData);

        $sendNotificationService = new SendNotificationService($httpClient);
        $valid = $sendNotificationService->handle(new Notification());

        self::assertTrue($valid);
    }

    public function testFailSend(){

        $expectedResponseData = [
            'message' => 'Failed'
        ];

        $httpClient = $this->mockHttpClient($expectedResponseData);

        $sendNotificationService = new SendNotificationService($httpClient);
        $valid = $sendNotificationService->handle(new Notification());

        self::assertNotTrue($valid);
    }

    public function testValidationFailed()
    {
        $httpClient = $this->mockHttpClient([], 500);

        $sendNotificationService = new SendNotificationService($httpClient);
        $valid = $sendNotificationService->handle(new Notification());

        self::assertNotTrue($valid);
    }

    private function mockHttpClient(array $expectedResponseData, $code = 200): HttpClientInterface
    {
        $mockResponseJson = json_encode($expectedResponseData, JSON_THROW_ON_ERROR);
        $mockResponse = new MockResponse($mockResponseJson, [
            'http_code' => $code,
            'response_headers' => ['Content-Type: application/json; charset=UTF-8'],
        ]);

        return new MockHttpClient($mockResponse);
    }
}