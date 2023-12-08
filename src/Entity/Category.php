<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntitySlugTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
#[ORM\HasLifecycleCallbacks]

class Category
{

    use EntityIdTrait;
    use EntityTimestampTrait;
    use EntitySlugTrait;
    
    #[ORM\Column(length: 100)]
    #[Groups(['category:read','category:edit','category:create', 'type: read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['category:read','category:edit','category:create', 'type:read'])]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Type::class,inversedBy: 'categories')]
    #[Groups(['category:read', 'category:create', 'category:edit'])]
    private ?Type $type = null;

    #[ORM\ManyToMany(targetEntity: self::class)]
    #[Groups(['category:read', 'category:create', 'category:edit', 'type:read'])]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    #[Groups(['media-file:read','media-file:edit','media-file:create'])]
    private ?MediaFile $coverImage = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'categories', cascade: ['persist', 'remove'])]
    #[Groups(['category:read'])]
    private Collection $products;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(self $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getCoverImage(): ?MediaFile
    {
        return $this->coverImage;
    }

    public function setCoverImage(?MediaFile $coverImage): static
    {
        $this->coverImage = $coverImage;

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
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }
}
