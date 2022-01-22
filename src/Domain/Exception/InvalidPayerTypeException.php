<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidPayerTypeException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Shopkeeper can\'t perform a transfer values for others users.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}