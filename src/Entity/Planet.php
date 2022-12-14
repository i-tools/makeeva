<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\AromaInterface;
use App\Interfaces\HTMLPageInterface;
use App\Interfaces\PlanetInterface;
use App\Interfaces\StoneInterface;
use App\Repository\PlanetRepository;
use App\Traits\HTMLPageTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'planets')]
#[ORM\Index(columns: ['slug'], name: 'idx_planets_slug')]
#[ORM\Entity(repositoryClass: PlanetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Planet implements HTMLPageInterface, PlanetInterface, TimestampableInterface
{
    use TimestampableTrait;
    use HTMLPageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2, max: 10,
        minMessage: 'Field must be at least {{ limit }} characters long"',
        maxMessage: 'Field cannot be longer than {{ limit }} characters'
    )]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\OneToMany(mappedBy: 'planet', targetEntity: Stone::class, cascade: ['persist'], fetch: 'EXTRA_LAZY')]
    private Collection $stones;

    #[ORM\OneToMany(mappedBy: 'planet', targetEntity: Aroma::class, cascade: ['persist'], fetch: 'EXTRA_LAZY')]
    private Collection $aromas;

    #[ORM\OneToMany(mappedBy: 'planet', targetEntity: Page::class, cascade: ['persist'], fetch: 'EXTRA_LAZY')]
    private Collection $pages;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Planet
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getStones(): Collection
    {
        return $this->stones;
    }

    public function setStones(Collection $stones): PlanetInterface
    {
        $this->stones = $stones;

        return $this;
    }

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

    public function removeStone(StoneInterface $stone): PlanetInterface
    {
        if ($this->stones->contains($stone)) {
            $this->stones->removeElement($stone);
            $stone->setPlanet(null);
        }

        return $this;
    }

    public function getAromas(): Collection
    {
        return $this->aromas;
    }

    public function setAromas(Collection $aromas): PlanetInterface
    {
        $this->aromas = $aromas;

        return $this;
    }

    public function addAroma(AromaInterface ...$aromas): PlanetInterface
    {
        foreach ($aromas as $aroma) {
            if (!$this->aromas->contains($aroma)) {
                $this->aromas->add($aroma);
                $aroma->setPlanet($this);
            }
        }

        return $this;
    }

    public function removeAroma(AromaInterface $aroma): PlanetInterface
    {
        if ($this->aromas->contains($aroma)) {
            $this->aromas->removeElement($aroma);
            $aroma->setPlanet(null);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
