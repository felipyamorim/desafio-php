<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Helper\TimestampableTrait;
use App\Infrastructure\Repository\TransferRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TransferRepository::class)]
class Transfer implements JsonSerializable
{
    use TimestampableTrait;

    const PENDING = 'pending';
    const APPROVED = 'approved';
    const DENIED = 'denied';

    #[ORM\Id]
    #[ORM\GeneratedValue("IDENTITY")]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $payer;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $payee;

    #[ORM\Column(type: 'decimal', precision: 20, scale: 2)]
    private string $value;

    #[ORM\Column(type: 'string', length: 25)]
    private string $status = self::PENDING;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayer(): ?User
    {
        return $this->payer;
    }

    public function setPayer(User $payer): self
    {
        $this->payer = $payer;

        return $this;
    }

    public function getPayee(): ?User
    {
        return $this->payee;
    }

    public function setPayee(User $payee): self
    {
        $this->payee = $payee;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'payer' => $this->getPayer()->getId(),
            'payee' => $this->getPayee()->getId(),
            'value' => $this->getValue(),
            'status' => $this->getStatus(),
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
