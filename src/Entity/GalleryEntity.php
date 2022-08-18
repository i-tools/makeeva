<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\GalleriedEntityInterface;
use App\Repository\GalleriedEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleriedEntityRepository::class)]
class GalleriedEntity implements GalleriedEntityInterface
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
     * @return GalleriedEntity
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
     * @return GalleriedEntity
     */
    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }
}
