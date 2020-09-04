<?php

namespace App\Entity;

use App\Repository\CollectionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CollectionRepository::class)
 */
class CollectionUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Helper\UuidGenerator")
     * @ORM\Column(type="string")
     *
     * @Groups({"collection-all"})
     */
    private ?string $id = null;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"collection-all"})
     */
    private ?string $name = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="collectionsUsers")
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="collectionsUsers")
     *
     * @Groups({"collection-all"})
     */
    private ?Category $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Element", mappedBy="collectionUser")
     *
     * @Groups({"collection-all"})
     */
    private ?Collection $elements;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Collection|Element[]
     */
    public function getElements(): ?Collection
    {
        return $this->elements;
    }

    public function addElement(Element $element): void
    {
        if (!$this->elements->contains($element)) {
            $this->elements->add($element);
            $element->setCollection($this);
        }
    }

    public function removeElement(Element $element): void
    {
        if ($this->elements->contains($element)) {
            $this->elements->removeElement($element);
            $element->setCollection(null);
        }
    }
}
