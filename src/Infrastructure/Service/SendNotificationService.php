<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Notification;
use App\Domain\Service\SendNotificationServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SendNotificationService implements SendNotificationServiceInterface
{
    const SUCCESS = 'Success';

    public function __construct(
        private HttpClientInterface $client
    ){}

    public function handle(Notification $notification): bool
    {
        try {
            $response = $this->client->request(
                'GET',
                'http://o4d9z.mocklab.io/notify'
            );

            $data = $response->toArray();

            return $data['message'] === self::SUCCESS;
        } catch (\Exception) {
            return false;
        }
    }
}