<?php

declare(strict_types=1);

namespace App\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;


class UserCommand
{
    #[Assert\NotBlank]
    #[Assert\Length(min:3)]
    private ?string $name;

    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min:11, max: 14)]
    private ?string $document;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;

        $document = preg_replace(
            '/\D/', '', $data['document'] ?? ''
        );

        $this->document = $document;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }
}