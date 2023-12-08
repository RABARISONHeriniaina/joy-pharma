<?php

namespace App\Entity;

//use ApiPlatform\Metadata\ApiProperty;
use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\MediaFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\Serializer\Annotation\ApiProperty;

#[ORM\Entity(repositoryClass: MediaFileRepository::class)]
#[ORM\Table(name: 'media_files')]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]

class MediaFile
{
    use EntityIdTrait;
    use EntityTimestampTrait;
    #[ORM\Column(length: 255)]
    #[Groups(['media-file:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    #[Groups(['media-file:read'])]
    private ?string $mimeType = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media-file:read'])]
    private ?string $originalName = null;

    #[ORM\OneToMany(mappedBy: 'coverImage', targetEntity: Type::class)]
    private Collection $types;

    #[ORM\OneToMany(mappedBy: 'coverImage', targetEntity: Category::class)]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Partenary::class)]
    private Collection $partenaries;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Brand::class)]
    private Collection $brands;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'name', mimeType: 'mimeType', originalName: 'originalName')]
    #[Groups(['media-file:create', 'media-file:edit'])]
    private ?File $file = null;

    #[Groups(['media-file:read'])]
    private ?string $path = null;


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

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): static
    {
        $this->mimeType = $mimeType;

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

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $file
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

}
