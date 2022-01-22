<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidDocumentException extends Exception
{
    public function __construct(string $email)
    {
        $message = sprintf('The document "%s" is invalid!', $email);

        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}