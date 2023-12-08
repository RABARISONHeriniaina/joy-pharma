<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\PartenaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PartenaryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'partenaries')]

class Partenary
{
    use EntityIdTrait;
    use EntityTimestampTrait;
    #[ORM\Column(length: 50)]
    #[Groups(['partenary:read', 'partenary:create', 'partenary:edit'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['partenary:read', 'partenary:create', 'partenary:edit'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['partenary:read', 'partenary:create', 'partenary:edit'])]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'partenaries')]
    #[Groups(['media-file:read', 'media-file:create', 'media-file:edit'])]
    private ?MediaFile $image = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

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
