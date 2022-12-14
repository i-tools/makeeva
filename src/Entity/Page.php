<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\HTMLPageInterface;
use App\Interfaces\PageInterface;
use App\Interfaces\SectionInterface;
use App\Repository\PageRepository;
use App\Traits\HTMLPageTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page implements PageInterface, HTMLPageInterface, TimestampableInterface
{
    use TimestampableTrait;
    use HTMLPageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'pages')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Section $section = null;

    #[ORM\ManyToOne(targetEntity: Planet::class, inversedBy: 'pages')]
    private ?Planet $planet = null;

    public function __construct()
    {
        $this->published = true;
        $this->slug = '';
    }

    /**
     * @return Section|null
     */
    public function getSection(): ?SectionInterface
    {
        return $this->section;
    }

    /**
     * @param SectionInterface|null $section
     * @return Page
     */
    public function setSection(?SectionInterface $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getPlanet(): ?Planet
    {
        return $this->planet;
    }

    /**
     * @param Planet|null $planet
     * @return Page
     */
    public function setPlanet(?Planet $planet): self
    {
        $this->planet = $planet;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
