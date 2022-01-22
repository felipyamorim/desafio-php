<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class TransferSameUserException extends \Exception
{
    public function __construct()
    {
        parent::__construct('It\'s not possible to perform a transfer to the same source user.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}