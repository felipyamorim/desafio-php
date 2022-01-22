<?php

namespace App\Tests\Unit\Infrastructure\MessageHandler;

use App\Domain\Entity\Transfer;
use App\Domain\Repository\TransferRepositoryInterface;
use App\Domain\Service\ApproveTransferServiceInterface;
use App\Domain\Service\DenyTransferServiceInterface;
use App\Infrastructure\Message\CreatedTransfer;
use App\Infrastructure\MessageHandler\CreatedTransferHandler;
use App\Infrastructure\Service\TransferAuthorizationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CreatedTransferHandlerTest extends TestCase
{
    public function testCreatedTransferHandlerSuccess()
    {
        $transferRepository = $this->createMock(TransferRepositoryInterface::class);
        $transferRepository->expects($this->once())->method('get')->willReturn(new Transfer());

        $expectedResponseData = [
            'message' => 'Autorizado'
        ];

        $httpClient = $this->mockHttpClient($expectedResponseData);
        $transferAuthorizationService = new TransferAuthorizationService($httpClient);

        $approveTransferService = $this->createMock(ApproveTransferServiceInterface::class);
        $approveTransferService->expects($this->once())->method('handle');

        $denyTransferService = $this->createMock(DenyTransferServiceInterface::class);

        $message = new CreatedTransfer(1);

        $transferNotificationHandler = new CreatedTransferHandler($transferRepository, $transferAuthorizationService, $approveTransferService, $denyTransferService);
        $transferNotificationHandler($message);
    }

    public function testCreatedTransferHandlerFail()
    {
        $transferRepository = $this->createMock(TransferRepositoryInterface::class);
        $transferRepository->expects($this->once())->method('get')->willReturn(new Transfer());

        $expectedResponseData = [
            'message' => 'Não Autorizado'
        ];

        $httpClient = $this->mockHttpClient($expectedResponseData);
        $transferAuthorizationService = new TransferAuthorizationService($httpClient);

        $approveTransferService = $this->createMock(ApproveTransferServiceInterface::class);

        $denyTransferService = $this->createMock(DenyTransferServiceInterface::class);
        $denyTransferService->expects($this->once())->method('handle');

        $message = new CreatedTransfer(1);

        $transferNotificationHandler = new CreatedTransferHandler($transferRepository, $transferAuthorizationService, $approveTransferService, $denyTransferService);
        $transferNotificationHandler($message);
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