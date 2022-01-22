<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidEmailException;

class Email implements \Stringable
{
    private string $email;

    public function __construct(string $value)
    {
        if(filter_var($value, FILTER_VALIDATE_EMAIL) === false){
            throw new InvalidEmailException($value);
        }

        $this->email = $value;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}