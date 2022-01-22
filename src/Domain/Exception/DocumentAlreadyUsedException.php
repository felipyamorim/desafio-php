<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class DocumentAlreadyUsedException extends Exception
{
    public function __construct(string $document)
    {
        $message = sprintf('The document "%s" is already used!', $document);

        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}