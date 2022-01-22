<?php

namespace App\Tests\Unit\Infrastructure\Service;

use App\Domain\Entity\Transfer;
use App\Domain\Entity\User;
use App\Infrastructure\Service\TransferAuthorizationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TransferAuthorizationServiceTest extends TestCase
{
    public function testValidate()
    {
        $expectedResponseData = [
            'message' => 'Autorizado'
        ];

        $httpClient = $this->mockHttpClient($expectedResponseData);

        $transferAuthorizationService = new TransferAuthorizationService($httpClient);
        $valid = $transferAuthorizationService->validate(new Transfer());

        self::assertTrue($valid);
    }

    public function testFailValidate()
    {
        $expectedResponseData = [
            'message' => 'Não Autorizado'
        ];

        $httpClient = $this->mockHttpClient($expectedResponseData);

        $transferAuthorizationService = new TransferAuthorizationService($httpClient);
        $valid = $transferAuthorizationService->validate(new Transfer());

        self::assertNotTrue($valid);
    }

    public function testValidationFailed()
    {
        $httpClient = $this->mockHttpClient([], 500);

        $transferAuthorizationService = new TransferAuthorizationService($httpClient);
        $valid = $transferAuthorizationService->validate(new Transfer());

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