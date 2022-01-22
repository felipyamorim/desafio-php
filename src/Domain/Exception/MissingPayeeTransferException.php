<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class MissingPayeeTransferException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The Payee is missing in transfer data.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}