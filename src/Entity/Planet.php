<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\PlanetInterface;
use App\Interfaces\StoneInterface;
use App\Repository\PlanetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Table(name: 'planets')]
#[ORM\Index(columns: ['slug'], name: 'idx_planets_slug')]
#[ORM\Entity(repositoryClass: PlanetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Planet implements PlanetInterface, TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'boolean')]
    private bool $published;

    #[ORM\OneToMany(mappedBy: 'planet', targetEntity: Stone::class, cascade: ['persist'], fetch: 'EXTRA_LAZY')]
    private Collection $stones;

    #[ORM\Column(length: 10)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

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
     * @return Collection
     */
    public function getStones(): Collection
    {
        return $this->stones;
    }

    /**
     * @param Collection $stones
     */
    public function setStones(Collection $stones): void
    {
        $this->stones = $stones;
    }

    /**
     * @param StoneInterface ...$stones
     * @return PlanetInterface
     */
    public function addStone(StoneInterface ...$stones): PlanetInterface
    {
        foreach ($stones as $stone) {
            if (!$this->stones->contains($stone)) {
                $this->stones->add($stone);
                $stone->setPlanet($this);
            }
        }

        return $this;
    }

    /**
     * @param StoneInterface $stone
     * @return PlanetInterface
     */
    public function removeQuest(StoneInterface $stone): PlanetInterface
    {
        if ($this->stones->contains($stone)) {
            $this->stones->removeElement($stone);
            $stone->setPlanet(null);
        }

        return $this;
    }

    /**
     * @param bool $published
     */
    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): PlanetInterface
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): PlanetInterface
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): PlanetInterface
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): PlanetInterface
    {
        $this->slug = $slug;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
