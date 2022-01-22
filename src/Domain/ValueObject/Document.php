<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidDocumentException;
use App\Domain\Helper\DocumentValidator;

class Document implements \Stringable
{
    private string $document;

    public function __construct(string $value)
    {
        $document = preg_replace('/[^0-9]/is', '', $value);

        $isValidDocument = strlen($document) === 11 ? DocumentValidator::cpf($document) : DocumentValidator::cnpj($document);

        if (!$isValidDocument) {
            throw new InvalidDocumentException($value);
        }

        $this->document = $document;
    }

    public function __toString(): string
    {
        return $this->document;
    }
}