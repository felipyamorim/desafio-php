<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class InsufficientFundsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Insufficient balance to make the transfer.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}