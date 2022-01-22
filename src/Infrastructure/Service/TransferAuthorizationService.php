<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Transfer;
use App\Domain\Service\TransferAuthorizationServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TransferAuthorizationService implements TransferAuthorizationServiceInterface
{
    const AUTHORIZED = 'Autorizado';

    public function __construct(
        private HttpClientInterface $client
    ){}

    public function validate(Transfer $transfer): bool
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6'
            );

            $data = $response->toArray();

            return $data['message'] === self::AUTHORIZED;
        } catch (\Exception) {
            return false;
        }
    }
}