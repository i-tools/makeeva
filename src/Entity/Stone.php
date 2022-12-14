<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\GalleriedEntityInterface;
use App\Interfaces\HTMLPageInterface;
use App\Interfaces\PlanetInterface;
use App\Interfaces\StoneInterface;
use App\Repository\StoneRepository;
use App\Traits\GalleriedEntityTrait;
use App\Traits\HTMLPageTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Table(name: 'stones')]
#[ORM\Index(columns: ['slug'], name: 'idx_stones_slug')]
#[ORM\Entity(repositoryClass: StoneRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Stone implements HTMLPageInterface, GalleriedEntityInterface, StoneInterface, TimestampableInterface
{
    use TimestampableTrait;
    use HTMLPageTrait;
    use GalleriedEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\ManyToOne(targetEntity: Planet::class, inversedBy: 'stones')]
    private ?PlanetInterface $planet = null;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): StoneInterface
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getPlanet(): ?PlanetInterface
    {
        return $this->planet;
    }

    public function setPlanet(?PlanetInterface $planet): StoneInterface
    {
        $this->planet = $planet;

        return $this;
    }
}
