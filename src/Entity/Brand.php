<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\BrandRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'brands')]

class Brand
{
    use EntityIdTrait;
    use EntityTimestampTrait;

    #[ORM\Column(length: 50)]
    #[Groups(['brand:read','brand:edit','brand:create'])]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['brand:read','brand:edit','brand:create'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'brands', cascade: ['persist', 'remove'])]
    #[Groups(['media-file:read','media-file:edit','media-file:create'])]
    private ?MediaFile $image = null;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?MediaFile
    {
        return $this->image;
    }

    public function setImage(?MediaFile $image): static
    {
        $this->image = $image;

        return $this;
    }
}
