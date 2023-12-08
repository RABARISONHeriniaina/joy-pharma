<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntitySlugTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
#[ORM\HasLifecycleCallbacks]

class Product
{
    use EntityIdTrait;
    use EntityTimestampTrait;
    use EntitySlugTrait;
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 20)]
    private ?string $state = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Restricted $restricted = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductPrice::class)]
    private Collection $productPrices;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Discount::class)]
    private Collection $discounts;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->productPrices = new ArrayCollection();
        $this->discounts = new ArrayCollection();
    }

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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getRestricted(): ?Restricted
    {
        return $this->restricted;
    }

    public function setRestricted(?Restricted $restricted): static
    {
        $this->restricted = $restricted;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, ProductPrice>
     */
    public function getProductPrices(): Collection
    {
        return $this->productPrices;
    }

    public function addProductPrice(ProductPrice $productPrice): static
    {
        if (!$this->productPrices->contains($productPrice)) {
            $this->productPrices->add($productPrice);
            $productPrice->setProduct($this);
        }

        return $this;
    }

    public function removeProductPrice(ProductPrice $productPrice): static
    {
        if ($this->productPrices->removeElement($productPrice)) {
            // set the owning side to null (unless already changed)
            if ($productPrice->getProduct() === $this) {
                $productPrice->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Discount>
     */
    public function getDiscounts(): Collection
    {
        return $this->discounts;
    }

    public function addDiscount(Discount $discount): static
    {
        if (!$this->discounts->contains($discount)) {
            $this->discounts->add($discount);
            $discount->setProduct($this);
        }

        return $this;
    }

    public function removeDiscount(Discount $discount): static
    {
        if ($this->discounts->removeElement($discount)) {
            // set the owning side to null (unless already changed)
            if ($discount->getProduct() === $this) {
                $discount->setProduct(null);
            }
        }

        return $this;
    }
}
