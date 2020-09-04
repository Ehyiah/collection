<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\OneToMany(targetEntity="App\Entity\CollectionUser", mappedBy="category")
     */
    private ?Collection $collectionsUsers;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"collection-all"})
     */
    private string $name;

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return Collection|CollectionUser[]
     */
    public function getCollectionsUsers(): ?Collection
    {
        return $this->collectionsUsers;
    }

    public function addCollectionsUser(CollectionUser $collection): void
    {
        if (!$this->collectionsUsers->contains($collection)) {
            $this->collectionsUsers->add($collection);
            $collection->setCategory($this);
        }
    }

    public function removeCollectionsUser(CollectionUser $collection): void
    {
        if ($this->collectionsUsers->contains($collection)) {
            $this->collectionsUsers->removeElement($collection);
            $collection->setCategory(null);
        }
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
