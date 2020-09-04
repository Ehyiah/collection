<?php

namespace App\Entity;

use App\Repository\ElementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ElementRepository::class)
 */
class Element
{
    public const ETAT_VERY_BAD = 'very_bad';
    public const ETAT_BAD = 'bad';
    public const ETAT_GOOD = 'good';
    public const ETAT_VERY_GOOD = 'very_good';
    public const ETAT_MINT = 'mint';
    public const ETAT_NEW = 'new';

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
    private string $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups({"collection-all"})
     */
    private ?string $region;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups({"collection-all"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups({"collection-all"})
     */
    private ?string $editor;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups({"collection-all"})
     */
    private ?string $etat;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups({"collection-all"})
     */
    private ?string $price;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Groups({"collection-all"})
     */
    private ?string $actualValue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups({"collection-all"})
     */
    private ?int $numberInPossession;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups({"collection-all"})
     */
    private ?int $players;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(?string $editor): void
    {
        $this->editor = $editor;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): void
    {
        $this->etat = $etat;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): void
    {
        $this->price = $price;
    }

    public function getActualValue(): ?string
    {
        return $this->actualValue;
    }

    public function setActualValue(?string $actualValue): void
    {
        $this->actualValue = $actualValue;
    }

    public function getNumberInPossession(): ?int
    {
        return $this->numberInPossession;
    }

    public function setNumberInPossession(?int $numberInPossession): void
    {
        $this->numberInPossession = $numberInPossession;
    }

    public function getPlayers(): ?int
    {
        return $this->players;
    }

    public function setPlayers(?int $players): void
    {
        $this->players = $players;
    }
}
