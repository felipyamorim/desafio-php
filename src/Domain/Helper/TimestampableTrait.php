<?php

declare(strict_types=1);

namespace App\Domain\Helper;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $createdAt = null;
    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $updatedAt = null;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new DateTimeImmutable());

        if($this->getCreatedAt() === null)
        {
            $this->setCreatedAt(new DateTimeImmutable());
        }
    }
}