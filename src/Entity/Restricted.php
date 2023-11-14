<?php

namespace App\Entity;

use App\Repository\RestrictedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'restricted', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setRestricted($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getRestricted() === $this) {
                $product->setRestricted(null);
            }
        }

        return $this;
    }
}
