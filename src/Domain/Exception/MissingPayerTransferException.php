<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class MissingPayerTransferException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The Payer is missing in transfer data.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}