<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\MediaFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MediaFileRepository::class)]
#[ORM\Table(name: 'media_files')]
#[ORM\HasLifecycleCallbacks]

class MediaFile
{
    use EntityIdTrait;
    use EntityTimestampTrait;
    #[ORM\Column(length: 255)]
    #[Groups(['media-file:read','media-file:edit','media-file:create'])]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    #[Groups(['media-file:read','media-file:edit','media-file:create'])]
    private ?string $extension = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media-file:read','media-file:edit','media-file:create'])]
    private ?string $originalName = null;

    #[ORM\OneToMany(mappedBy: 'coverImage', targetEntity: Type::class)]
    private Collection $types;

    #[ORM\OneToMany(mappedBy: 'coverImage', targetEntity: Category::class)]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Partenary::class)]
    private Collection $partenaries;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Brand::class)]
    private Collection $brands;

    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->partenaries = new ArrayCollection();
        $this->brands = new ArrayCollection();
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

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->setCoverImage($this);
        }

        return $this;
    }

    public function removeType(Type $type): static
    {
        if ($this->types->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getCoverImage() === $this) {
                $type->setCoverImage(null);
            }
        }

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
            $category->setCoverImage($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCoverImage() === $this) {
                $category->setCoverImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Partenary>
     */
    public function getPartenaries(): Collection
    {
        return $this->partenaries;
    }

    public function addPartenary(Partenary $partenary): static
    {
        if (!$this->partenaries->contains($partenary)) {
            $this->partenaries->add($partenary);
            $partenary->setImage($this);
        }

        return $this;
    }

    public function removePartenary(Partenary $partenary): static
    {
        if ($this->partenaries->removeElement($partenary)) {
            // set the owning side to null (unless already changed)
            if ($partenary->getImage() === $this) {
                $partenary->setImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Brand>
     */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function addBrand(Brand $brand): static
    {
        if (!$this->brands->contains($brand)) {
            $this->brands->add($brand);
            $brand->setImage($this);
        }

        return $this;
    }

    public function removeBrand(Brand $brand): static
    {
        if ($this->brands->removeElement($brand)) {
            // set the owning side to null (unless already changed)
            if ($brand->getImage() === $this) {
                $brand->setImage(null);
            }
        }

        return $this;
    }
}
