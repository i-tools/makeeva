<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\PlanetInterface;
use App\Interfaces\StoneInterface;
use App\Repository\StoneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Table(name: 'stones')]
#[ORM\Index(columns: ['slug'], name: 'idx_stones_slug')]
#[ORM\Entity(repositoryClass: StoneRepository::class)]
class Stone implements StoneInterface, TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'boolean')]
    private bool $published;

    #[ORM\ManyToOne(targetEntity: Planet::class, inversedBy: 'stones')]
    private ?PlanetInterface $planet = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(length: 10)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return StoneInterface
     */
    public function setPublished(bool $published): StoneInterface
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return StoneInterface
     */
    public function setTitle(?string $title): StoneInterface
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return PlanetInterface|null
     */
    public function getPlanet(): ?PlanetInterface
    {
        return $this->planet;
    }

    /**
     * @param PlanetInterface|null $planet
     * @return StoneInterface
     */
    public function setPlanet(?PlanetInterface $planet): StoneInterface
    {
        $this->planet = $planet;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string|null $imageName
     * @return StoneInterface
     */
    public function setImageName(?string $imageName): StoneInterface
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return StoneInterface
     */
    public function setContent(?string $content): StoneInterface
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return StoneInterface
     */
    public function setSlug(?string $slug): StoneInterface
    {
        $this->slug = $slug;

        return $this;
    }
}
