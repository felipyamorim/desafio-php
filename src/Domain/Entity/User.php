<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Helper\TimestampableTrait;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements JsonSerializable
{
    use TimestampableTrait;

    CONST TYPE_COMMON = 'common';
    CONST TYPE_SHOPKEEPER = 'shopkeeper';

    #[ORM\Id]
    #[ORM\GeneratedValue("IDENTITY")]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 15)]
    private string $type;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'vo_document', length: 14, unique: true)]
    private Document $document;

    #[ORM\Column(type: 'vo_email', length: 50, unique: true)]
    private Email $email;

    #[ORM\Column(type: 'decimal', precision: 20, scale: 2)]
    private string $balance = '0.00';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDocument(): ?string
    {
        return (string) $this->document;
    }

    public function setDocument(Document $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getEmail(): ?string
    {
        return (string) $this->email;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }

    public function addBalance(string $value): self
    {
        $this->balance = bcadd($this->balance, $value);

        return $this;
    }

    public function removeBalance(string $value): self
    {
        $this->balance = bcsub($this->balance,  $value);

        return $this;
    }

    public function isShopkeeper(): bool
    {
        return $this->getType() === self::TYPE_SHOPKEEPER;
    }

    public function isCommon(): bool
    {
        return $this->getType() === self::TYPE_COMMON;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'document' => $this->getDocument(),
            'email' => $this->getEmail(),
            'type' => $this->getType(),
            'balance' => $this->getBalance(),
            'created_at' => [
                'date' => $this->getCreatedAt()->format('Y/m/d H:i:s'),
                'timezone' => $this->getCreatedAt()->getTimezone()->getName()
            ],
            'updated_at' => [
                'date' => $this->getUpdatedAt()->format('Y/m/d H:i:s'),
                'timezone' => $this->getUpdatedAt()->getTimezone()->getName()
            ]
        ];
    }
}
