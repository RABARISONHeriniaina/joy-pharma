<?php

namespace App\Entity;

use App\Repository\RestrictedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestrictedRepository::class)]
class Restricted
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $waitingFor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWaitingFor(): ?string
    {
        return $this->waitingFor;
    }

    public function setWaitingFor(string $waitingFor): static
    {
        $this->waitingFor = $waitingFor;

        return $this;
    }
}
