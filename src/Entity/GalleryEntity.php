<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\GalleriedEntityInterface;
use App\Interfaces\GalleryEntityInterface;
use App\Repository\GalleryEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'galleries_entities')]
#[ORM\Entity(repositoryClass: GalleryEntityRepository::class)]
#[ORM\HasLifecycleCallbacks]
class GalleryEntity implements GalleryEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $imageName;

    public function getId(): ?int
    {
        return $this->id;
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
     * @return GalleryEntity
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName(): string
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     * @return GalleryEntity
     */
    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getImageName();
    }
}
