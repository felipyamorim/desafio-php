<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Infrastructure\Validator\Constraints\UserExists;
use Symfony\Component\Validator\Constraints as Assert;

class TransferCommand
{
    #[Assert\NotBlank]
    #[UserExists]
    private ?int $payer;

    #[Assert\NotBlank]
    #[UserExists]
    private ?int $payee;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    private ?float $value;

    public function __construct(array $data)
    {
        $this->payer = $data['payer'] ?? null;
        $this->payee = $data['payee'] ?? null;
        $this->value = $data['value'] ?? null;
    }

    public function getPayer(): ?int
    {
        return $this->payer;
    }

    public function getPayee(): ?int
    {
        return $this->payee;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }
}