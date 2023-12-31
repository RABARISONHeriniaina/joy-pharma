<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\DiscountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DiscountRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'discounts')]
class Discount
{

    use EntityIdTrait;
    use EntityTimestampTrait;
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['discount:read', 'discount:create', 'discount:edit'])]
    private ?string $off = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['discount:read', 'discount:create', 'discount:edit'])]
    private ?string $detail = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['discount:read', 'discount:create', 'discount:edit'])]
    private ?string $reason = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['discount:read', 'discount:create', 'discount:edit'])]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['discount:read', 'discount:create', 'discount:edit'])]
    private ?\DateTimeInterface $endedAt = null;

    #[ORM\ManyToOne(inversedBy: 'discounts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['discount:read', 'discount:create', 'discount:edit', 'product:read'])]
    private ?Product $product = null;

    public function getOff(): ?string
    {
        return $this->off;
    }

    public function setOff(string $off): static
    {
        $this->off = $off;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->endedAt;
    }

    public function setEndedAt(\DateTimeInterface $endedAt): static
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
