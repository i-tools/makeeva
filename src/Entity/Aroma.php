<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\AromaInterface;
use App\Interfaces\GalleriedEntityInterface;
use App\Interfaces\HTMLPageInterface;
use App\Interfaces\PlanetInterface;
use App\Repository\AromaRepository;
use App\Traits\GalleriedEntityTrait;
use App\Traits\HTMLPageTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'aromas')]
#[ORM\Index(columns: ['slug'], name: 'idx_aromas_slug')]
#[ORM\Entity(repositoryClass: AromaRepository::class)]
class Aroma implements HTMLPageInterface, AromaInterface, GalleriedEntityInterface, TimestampableInterface
{
    use TimestampableTrait;
    use HTMLPageTrait;
    use GalleriedEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Planet::class, inversedBy: 'aromas')]
    private ?PlanetInterface $planet = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imageName = null;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Aroma
     */
    public function setPlanet(?PlanetInterface $planet): self
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
     * @return Aroma
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }
}
