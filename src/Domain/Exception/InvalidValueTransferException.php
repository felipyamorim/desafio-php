<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidValueTransferException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid amount to make the transfer.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}