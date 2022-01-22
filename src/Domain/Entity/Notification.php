<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Helper\TimestampableTrait;
use App\Infrastructure\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification implements \JsonSerializable
{
    use TimestampableTrait;

    const PENDING = 'pending';
    const SENT = 'sent';
    const FAILED = 'failed';

    #[ORM\Id]
    #[ORM\GeneratedValue("IDENTITY")]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $receiver;

    #[ORM\OneToOne(targetEntity: Transfer::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Transfer $transfer;

    #[ORM\Column(type: 'string', length: 25)]
    private $status = 'pending';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getTransfer(): ?Transfer
    {
        return $this->transfer;
    }

    public function setTransfer(?Transfer $transfer): self
    {
        $this->transfer = $transfer;

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
            'receiver' => $this->getReceiver()->getId(),
            'transfer' => $this->getTransfer()->getId(),
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
