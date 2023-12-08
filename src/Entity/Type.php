<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntitySlugTrait;
use App\Entity\Traits\EntityTimestampTrait;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ORM\Table(name: 'types')]
#[ORM\HasLifecycleCallbacks]

class Type
{

    use EntityIdTrait;
    use EntityTimestampTrait;
    use EntitySlugTrait;
    #[ORM\Column(length: 100)]
    #[Groups(['type:read','type:edit','type:create'])]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['type:read','type:edit','type:create'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Category::class)]
    #[Groups(['type:read'])]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'types')]
    #[Groups(['media-file:read','media-file:edit','media-file:create'])]
    private ?MediaFile $coverImage = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
            $category->setType($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getType() === $this) {
                $category->setType(null);
            }
        }

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
}
