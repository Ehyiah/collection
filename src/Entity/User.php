<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Helper\UuidGenerator")
     * @ORM\Column(type="string")
     */
    private ?string $id = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    private ?string $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CollectionUser", mappedBy="user")
     */
    private Collection $collectionsUsers;

    private ?string $plainPassword = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
         $this->plainPassword = null;
    }

    /**
     * @return Collection|CollectionUser[]
     */
    public function getCollectionsUsers(): Collection
    {
        return $this->collectionsUsers;
    }

    public function addCollectionUsers(CollectionUser $collection): void
    {
        if (!$this->collectionsUsers->contains($collection)) {
            $this->collectionsUsers->add($collection);
            $collection->setUser($this);
        }
    }

    public function removeCollectionUsers(CollectionUser $collection): void
    {
        if ($this->collectionsUsers->contains($collection)) {
            $this->collectionsUsers->removeElement($collection);
            $collection->setUser(null);
        }
    }
}
