<?php

namespace App\Entity;

use App\Repository\ElementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElementRepository::class)
 */
class Element
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Helper\UuidGenerator")
     * @ORM\Column(type="string")
     */
    private ?string $id = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CollectionUser", inversedBy="elements")
     */
    private CollectionUser $collectionUser;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCollectionUser(): CollectionUser
    {
        return $this->collectionUser;
    }

    public function setCollectionUser(CollectionUser $collection): void
    {
        $this->collectionUser = $collection;
    }
}
