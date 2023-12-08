<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\ManufacturerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManufacturerRepository::class)]
#[ORM\Table(name: 'manufacturer')]
#[ORM\HasLifecycleCallbacks]
class Manufacturer
{
    use EntityIdTrait;
    use EntityTimestampTrait;

    #[ORM\Column(length: 50)]
    #[Groups(['manufacturer:read', 'manufacturer:create', 'manufacturer:edit'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['manufacturer:read', 'manufacturer:create', 'manufacturer:edit'])]
    private ?string $description = null;

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

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
